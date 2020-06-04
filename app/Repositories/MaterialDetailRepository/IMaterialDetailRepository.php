<?php
namespace App\Repositories\MaterialDetailRepository;

interface IMaterialDetailRepository{
    function getTypeMaterial();
    function showMaterialDetail();
    function validatorRequestStore($req);
    function addMaterialDetail($request);
    function searchMaterialDetail($request);
    function validatorRequestUpdate($req);
    function updateNameMaterialDetail($request,$id);
    function updateTypeMaterialDetail($request,$id);
    function deleteMaterialDetail($id);

}
