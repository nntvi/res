<?php
namespace App\Repositories\MethodRepository;

interface IMethodRepository{
    function checkMethod($temp);
    function createStringTu($qtyTu,$textTu,$calTu);
    function createStringMau($qtyMau,$textMau,$calMau);
    function saveTextMethod($stringTu,$stringMau,$qtyTu,$qtyMau,$arrCalTu,$arrCalMau);
    function createNumTu($request,$id);
    function createNumMau($request,$id);
}
