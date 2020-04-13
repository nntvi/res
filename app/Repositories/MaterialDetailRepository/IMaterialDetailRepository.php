<?php
namespace App\Repositories\MaterialDetailRepository;

interface IMaterialDetailRepository{
    function getTypeMaterial();
    function showMaterialDetail();
    function validatorRequestStore($req);
    function addMaterialDetail($request);
    function validatorRequestSearch($req);
    function searchMaterialDetail($request);
    function validatorRequestUpdate($req);
    function updateMaterialDetail($request,$id);
    function deleteMaterialDetail($id);

}
