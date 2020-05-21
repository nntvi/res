<?php

namespace App\Http\Controllers;

use App\Method;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function index()
    {
        $methods = Method::all();
        return view('method.index',compact('methods'));
    }

    public function viewStoreText()
    {
        return view('method.storetext');
    }

    public function checkMethod($temp)
    {
        $method = "";
        switch ($temp) {
            case '0':
                $method = "+";
                break;
            case '1':
                $method = "-";
                break;
            case '2':
                $method = "*";
                break;
            case '3':
                $method = "/";
                break;
            default:
        }
        return $method;
    }

    public function storeText(Request $request)
    {
        $methodTuSo = $request->methodTuSo;
        $methodMauSo = $request->methodMauSo;
        $textTu = "";
        $textMau = "";
        for ($i=0; $i < count($request->nameNumerator); $i++) {
            if($i % 2 == 0){
                $textTu = $textTu . $request->nameNumerator[$i] . " ";
            }else{
                $textTu = $textTu . $this->checkMethod($methodTuSo[$i-1]) . " " . $request->nameNumerator[$i] . " ";
            }
        }
        for ($i=0; $i < count($request->nameDenominator); $i++) {
            if($i % 2 == 0){
                $textMau = $textMau . $request->nameDenominator[$i] . " ";
            }else{
                $textMau = $textMau . $this->checkMethod($methodMauSo[$i-1]) . " " . $request->nameDenominator[$i] . " ";
            }
        }

        $numTu = "";
        $numMau = "";
        for ($i=0; $i < count($request->nameNumerator); $i++) {
            if($i % 2 == 0){
                $numTu = $numTu . $request->numNumerator[$i] . " ";
            }else{
                $numTu = $numTu . $this->checkMethod($methodTuSo[$i-1]) . " " . $request->numNumerator[$i] . " ";
            }
        }
        for ($i=0; $i < count($request->nameDenominator); $i++) {
            if($i % 2 == 0){
                $numMau = $numMau . $request->numDenominator[$i] . " ";
            }else{
                $numMau = $numMau . $this->checkMethod($methodMauSo[$i-1]) . " " . $request->numDenominator[$i] . " ";
            }
        }
        $method = new Method();
        $method->textTuso = $textTu;
        $method->textMauso = $textMau;
        $method->tuso = $numTu;
        $method->mauso = $numMau;
        $method->result = $request->result;
        $method->status = '0';
        $method->save();
        return redirect(route('method.index'));
    }

    public function update($id)
    {
        $idDiff = Method::whereNotIn('id',[$id])->update(['status' => '0']);
        Method::where('id',$id)->update(['status' => '1']);
        return redirect(route('method.index'));
    }
}
