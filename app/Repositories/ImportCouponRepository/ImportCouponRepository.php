<?php
namespace App\Repositories\ImportCouponRepository;

use App\Http\Controllers\Controller;
use App\ImportCoupon;
use App\ImportCouponDetail;
use App\Supplier;
use App\MaterialDetail;
use App\TypeMaterial;
use App\Unit;
use App\WareHouse;
use App\WarehouseCook;

class ImportCouponRepository extends Controller implements IImportCouponRepository{
    public function getListImport()
    {
        $listImports = ImportCoupon::with('supplier')->get();
        return $listImports;
    }

    public function getSuppliers()
    {
        $suppliers = Supplier::all();
        return $suppliers;
    }

    public function getMaterialDetail()
    {
        $material_details = MaterialDetail::orderBy('name')->get();
        return $material_details;
    }

    public function getUnit()
    {
        $units = Unit::orderBy('name')->get();
        return $units;
    }

    public function getTypeMaterial()
    {
        $types = TypeMaterial::orderBy('name')->get();
        return $types;
    }

    public function showIndex()
    {
        $listImports = $this->getListImport();
        return view('importcoupon.index',compact('listImports'));
    }

    public function showViewImport()
    {
        $suppliers = $this->getSuppliers();
        $units = $this->getUnit();
        $types = $this->getTypeMaterial();
        $material_details = $this->getMaterialDetail();
        return view('importcoupon.import',compact('suppliers','units','material_details','types'));
    }

    public function countMaterialImport($request)
    {
        $count = count($request->id);
        return $count;
    }

    public function createImportCouponDetail($request,$i)
    {
        $importcouponDetail = new ImportCouponDetail();
        $importcouponDetail->code_import = $request->code;
        $importcouponDetail->id_material_detail = $request->idMaterial[$i];
        $importcouponDetail->qty = $request->qty[$i];
        $importcouponDetail->id_unit = $request->id_unit[$i];
        $importcouponDetail->price = $request->price[$i];
        $importcouponDetail->save();
    }

    public function findDetailImportCouponByCode($code)
    {
        $detailImports = ImportCouponDetail::where('code_import',$code)->with('materialDetail','unit')->get();
        return $detailImports;
    }

    public function getTotalDetailImportCoupon($detailImports)
    {
        $total = 0;
        foreach ($detailImports as $key => $detail) {
            $total += $detail->price;
        }
        return $total;
    }
    public function createImportCoupon($request)
    {
        $importcouponDetail = ImportCouponDetail::where('code_import',$request->code)->get();
        $total = $this->getTotalDetailImportCoupon($importcouponDetail);
        $importCoupon = new ImportCoupon();
        $importCoupon->code = $request->code;
        $importCoupon->id_supplier = $request->idSupplier;
        $importCoupon->total = $total;
        $importCoupon->note = $request->note;
        $importCoupon->save();
    }

    public function getOldQty($i,$request)
    {
        $oldQty = WareHouse::where('id',$request->id[$i])->value('qty');
        return $oldQty;
    }
    public function import($request)
    {
        $count = $this->countMaterialImport($request);
        for ($i=0; $i < $count; $i++) {
            $oldQty = $this->getOldQty($i,$request);
            $material = WareHouse::where('id',$request->id[$i])
                                    ->update([  'qty' => $oldQty + $request->qty[$i],
                                                'id_unit' => $request->id_unit[$i],
                                    ]);
            $importcouponDetail = $this->createImportCouponDetail($request,$i);
        }
        $this->createImportCoupon($request);
        return redirect(route('importcoupon.index'));
    }

    public function findDetailImportCouponByIdImport($id)
    {
        $detailImport = ImportCoupon::where('id',$id)
                        ->with('detailImportCoupon.materialDetail','detailImportCoupon.unit','supplier')
                        ->get();
        return $detailImport;
    }

    public function getDetailImportCouponById($id)
    {
        $importCoupon = $this->findDetailImportCouponByIdImport($id);
        return view('importcoupon.detail',compact('importCoupon'));
    }

    public function updateDetailImportCoupon($request,$id)
    {
        $detailImport = ImportCouponDetail::where('id',$id)->update(['price' => $request->price]);
        $code = ImportCouponDetail::where('id',$id)->first('code_import');
        $allDetailByCode = $this->findDetailImportCouponByCode($code->code_import);
        $sum = $this->getTotalDetailImportCoupon($allDetailByCode);
        $import = ImportCoupon::where('code',$code->code_import)->update(['total' => $sum]);
        $idImport = ImportCoupon::where('code',$code->code_import)->first('id');
        return redirect(route('importcoupon.detail',['id' => $idImport]));
    }

    public function findImportCouponByCode($code)
    {
        $import = ImportCoupon::where('code',$code)->with('supplier')->first();
        return $import;
    }

    public function printDetailByCode($id)
    {
        $importCoupon = $this->findDetailImportCouponByIdImport($id);
        return view('importcoupon.print',compact('importCoupon'));
    }
}
