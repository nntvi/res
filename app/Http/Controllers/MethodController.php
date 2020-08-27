<?php

namespace App\Http\Controllers;

use App\Method;
use App\Repositories\MethodRepository\IMethodRepository;
use Illuminate\Http\Request;
use App\Helper\ICheckAction;

class MethodController extends Controller
{
    private $methodRepository;
    private $checkAction;
    public function __construct(ICheckAction $checkAction, IMethodRepository $methodRepository)
    {
        $this->checkAction = $checkAction;
        $this->methodRepository = $methodRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->methodRepository->checkRoleIndex($result);
        if($check != 0){
            $methods = Method::get();
            return view('method.index',compact('methods'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function viewStoreText()
    {
        return view('method.storetext');
    }

    public function getQty(Request $request)
    {
        $qtyTu = $request->qtyTu;
        $qtyMau = $request->qtyMau;
        return view('method.storetext',compact('qtyTu','qtyMau'));
    }

    public function storeText(Request $request)
    {
        $qtyTu = $request->qtyTu;
        $qtyCalTu = $request->qtyTu - 1;
        $qtyMau = $request->qtyMau;
        $qtyCalMau = $request->qtyMau - 1;
        $arrCalTu = $request->calTu;
        $arrCalMau = $request->calMau;
        $stringTu = $this->methodRepository->createStringTu($qtyTu,$request->textTu,$request->calTu);
        $stringMau = $this->methodRepository->createStringMau($qtyMau,$request->textMau,$request->calMau);
        return $this->methodRepository->saveTextMethod($stringTu,$stringMau,$qtyTu,$qtyMau,$arrCalTu,$arrCalMau);
    }

    public function storeNumber(Request $request,$id)
    {
        //dd($request->all());
        $tu = (float) $this->methodRepository->createNumTu($request,$id);
        $mau = (float) $this->methodRepository->createNumMau($request,$id);
        if($mau == 0 ){
            return redirect(route('method.index'))->withErrors('Vui lòng thiết lập mẫu số > 0');
        }else{
            $stringNumTu = $this->methodRepository->createStringTu($request->qtyTu,$request->numTu,$request->calNumTu);
            $stringNumMau = $this->methodRepository->createStringMau($request->qtyTu,$request->numMau,$request->calNumMau);
            Method::where('id',$id)->update(['result' => round(($tu/$mau),2),'tuso' => $stringNumTu, 'mauso' => $stringNumMau,'status' => '0']);
            return redirect(route('method.index'))->withSuccess('Tạo công thức thành công');
        }
    }

    public function update($id)
    {
        $idDiff = Method::whereNotIn('id',[$id])->update(['status' => '0']);
        Method::where('id',$id)->update(['status' => '1']);
        return redirect(route('method.index'))->withSuccess('Cập nhật thành công');
    }

    public function delete($id)
    {
        Method::where('id',$id)->delete();
        return redirect(route('method.index'))->withSuccess('Xóa công thức thành công');
    }

    public function reset()
    {
        $methods = Method::all();
        foreach ($methods as $key => $method) {
            $method->status = '0';
            $method->save();
        }
        return redirect(route('method.index'))->withSuccess('Reset thành công');
    }
}
