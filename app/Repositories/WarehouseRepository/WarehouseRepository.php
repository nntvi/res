<?php
namespace App\Repositories\WarehouseRepository;

use App\Http\Controllers\Controller;
use App\WareHouse;
use App\Supplier;
use App\MaterialDetail;
use App\Unit;
use App\WareHouseDetail;

class WarehouseRepository extends Controller implements IWarehouseRepository{

    public function getListImport()
    {
        $listImports = WareHouse::with('supplier')->get();
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

        public function showIndex()
    {
        $listImports = $this->getListImport();
        return view('warehouse.index',compact('listImports'));
    }

    public function showViewImport()
    {
        $suppliers = $this->getSuppliers();
        $units = $this->getUnit();
        $material_details = $this->getMaterialDetail();
        return view('warehouse.import',compact('suppliers','units','material_details'));
    }

    public function countMaterialImport($request)
    {
        $count = count($request->id_material);
        return $count;
    }

    public function createWarehouseDetail()
    {
        $detail_warehouse = new WareHouseDetail();
        return $detail_warehouse;
    }

    public function createWarehouse()
    {
        $warehouse = new WareHouse();
        return $warehouse;
    }
    public function importWarehouse($request)
    {
        $count = $this->countMaterialImport($request);
        $sum = 0;
        for ($i=0; $i < $count; $i++) {
            $detail_warehouse = $this->createWarehouseDetail();
            $detail_warehouse->code_import = $request->code;
            $detail_warehouse->id_material_detail = $request->id_material[$i];
            $detail_warehouse->qty = $request->qty[$i];
            $detail_warehouse->id_unit = $request->id_unit[$i];
            $detail_warehouse->price = $request->price[$i];
            $sum+= $request->qty[$i] * $request->price[$i];
            $detail_warehouse->save();
        }

        $warehouse = $this->createWarehouse();
        $warehouse->code = $request->code;
        $warehouse->id_supplier = $request->supplier;
        $warehouse->note = $request->note;
        $warehouse->total = $sum;
        $warehouse->save();

        return redirect(route('warehouse.index'));
    }

    public function findDetailWarehouseById($id)
    {
        $detailImport = WareHouseDetail::find($id);
        return $detailImport;
    }

    public function getDetailWarehouseByCode($code)
    {
        $check = WareHouseDetail::where('code_import',$code)
                                    ->with('materialDetail','unit')
                                    ->get();
        return $check;
    }
    public function updateDetailWarehouse($request,$id)
    {
        $detailImport = $this->findDetailWarehouseById($id);
        $code = $detailImport->code_import;
        $detailImport->qty = $request->qty;
        $detailImport->id_unit = $request->id_unit;
        $detailImport->price = $request->price;
        $detailImport->save();

        $check = $this->getDetailWarehouseByCode($code);
        $sum = 0;
        foreach ($check as $key => $value) {
            $sum += $value->qty * $value->price;
        }
        $import = WareHouse::where('code',$code)->update(['total' => $sum]);

        return redirect(route('warehouse.detail',['code' => $code]));
    }

    public function findWarehouseByCode($code)
    {
        $import = WareHouse::where('code',$code)->with('supplier')->first();
        return $import;
    }

    public function findDetailWarehouseByCode($code)
    {
        $detailImports = WareHouseDetail::where('code_import',$code)->with('materialDetail','unit')->get();
        return $detailImports;
    }
    public function printDetailByCode($code)
    {
        $import = $this->findWarehouseByCode($code);
        $detailImports = $this->findDetailWarehouseByCode($code);
        return view('warehouse.print',compact('import','detailImports'));
    }

    // public function testExcel()
    // {
    //     $res = Excel::toArray(new WareHouseDetailImport, 'test.xlsx');
    //     //dd($res);
    //     foreach ($res as $key => $round) {
    //         foreach ($round as $key => $value) {
    //             $imp = WareHouseDetail::create($value);
    //         }
    //     }
    // }
}
