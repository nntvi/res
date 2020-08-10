<?php
namespace App\Repositories\MethodRepository;

use App\Http\Controllers\Controller;
use App\Method;

class MethodRepository extends Controller implements IMethodRepository{
    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL"){
                $temp++;
            }
        }
        return $temp;
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

    public function createStringTu($qtyTu,$textTu,$calTu)
    {
        $stringTu = "";
        for ($i=0; $i < $qtyTu; $i++) {
            if($i == 0){
                $stringTu = $stringTu . $textTu[$i];
            }else{
                $stringTu = $stringTu . " " . $this->checkMethod($calTu[$i-1]) . " ";
                $stringTu = $stringTu . $textTu[$i];
            }
        }
        return $stringTu;
    }

    public function createStringMau($qtyMau,$textMau,$calMau)
    {
        $stringMau = "";
        for ($i=0; $i < $qtyMau; $i++) {
            if($i == 0){
                $stringMau = $stringMau . $textMau[$i];
            }else{
                $stringMau = $stringMau . " " . $this->checkMethod($calMau[$i-1]) . " ";
                $stringMau = $stringMau . $textMau[$i];
            }
        }
        return $stringMau;
    }

    public function saveTextMethod($stringTu,$stringMau,$qtyTu,$qtyMau,$arrCalTu,$arrCalMau)
    {
        $method = new Method();
        $method->textTuSo = $stringTu;
        $method->textMauSo = $stringMau;
        $method->save();
        $idMethod = (int) $method->id;
        return view('method.storenumber',compact('qtyTu','qtyMau','stringTu','stringMau','idMethod','arrCalTu','arrCalMau'));
    }

    public function calculateTu($vt1,$cal,$vt2)
    {
        switch ($cal) {
            case '0':
                return $vt1 + $vt2;
                break;
            case '1':
                return $vt1 - $vt2;
                break;
            case '2':
                return $vt1 * $vt2;
                break;
            case '3':
                return $vt1 / $vt2;
                break;
            default:
        }
    }

    public function checkMultipandDiv($arr)
    {
        $arrTemp = array();
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == '2' || $arr[$i] == '3'){
                array_push($arrTemp,$i);
            }
        }
        return $arrTemp;
    }

    public function checkTrueFalseCal($checkMulDiv,$j)
    {
        $temp = 0;
        for ($i=0; $i < count($checkMulDiv); $i++) {
            if($checkMulDiv[$i] == $j){
                $temp++;
                break;
            }
        }
        return $temp == 0 ? false : true ;
    }

    public function caculateAllTu($arrNumTu,$arrCalNumTu)
    {
        $resutlTu = 0;
        for ($i=0; $i < count($arrNumTu); $i++) {
            if($i == 0){
                $resutlTu  += (int) $arrNumTu[$i];
            }else{
                $resutlTu = $this->calculateTu($resutlTu,$arrCalNumTu[$i-1],$arrNumTu[$i]);
            }
        }
        return $resutlTu;
    }

    public function getResult($checkMulDiv,$qty,$arrNum,$arrCalNum,$arrTempNum,$arrTempCal)
    {
        if(count($checkMulDiv) > 0){
            for ($i=0; $i < (int) $qty; $i++) {
                if($this->checkTrueFalseCal($checkMulDiv,$i)){
                    $temp = $this->calculateTu($arrNum[$i],$arrCalNum[$i],$arrNum[$i+1]);
                    array_push($arrTempNum,$temp);
                    if(($i+1) >= ($qty - 1)){
                        break;
                    }else{
                        array_push($arrTempCal,$arrCalNum[$i+1]);
                        $i = $i + 2;
                        if($i >= $qty){
                            break;
                        }
                    }
                }else{
                    array_push($arrTempNumTu,$arrNum[$i]);
                    if($i < ($qty - 1)){
                        array_push($arrTempCal,$arrCalNum[$i]);
                    }
                }
            }
            $resutlTu = $this->caculateAllTu($arrTempNum,$arrTempCal);
        }else{
            $resutlTu = $this->caculateAllTu($arrNum,$arrCalNum);
        }
        return $resutlTu;
    }

    public function createNumTu($request,$id)
    {
        $qtyTu = $request->qtyTu;
        $arrNumTu = $request->numTu; // số đc nhập
        $arrCalNumTu = $request->calNumTu; // phép tính đc nhập
        if($arrCalNumTu == null){
            return $arrNumTu[0];
        }else{
            $checkMulDiv = $this->checkMultipandDiv($arrCalNumTu);
            $arrTempNumTu = array();
            $arrTempCalTu = array();
            $resutlTu = $this->getResult($checkMulDiv,$qtyTu,$arrNumTu,$arrCalNumTu,$arrTempNumTu,$arrTempCalTu);
            return $resutlTu;
        }
    }

    public function createNumMau($request,$id)
    {
        $qtyMau = $request->qtyMau;
        $arrNumMau = $request->numMau; // số đc nhập
        $arrCalNumMau = $request->calNumMau; // phép tính đc nhập
        if($arrCalNumMau == null){
            return $arrCalNumMau[0];
        }else{
            $checkMulDiv = $this->checkMultipandDiv($arrCalNumMau);
            $arrTempNumMau = array();
            $arrTempCalMau = array();
            $resutlMau = $this->getResult($checkMulDiv,$qtyMau,$arrNumMau,$arrCalNumMau,$arrTempNumMau, $arrTempCalMau);
            return $resutlMau;
        }
    }
}
