<?php
namespace App\Repositories\MaterialDetailRepository;

interface IMaterialDetailRepository{
    function getTypeMaterial();
    function getUnit();
    function getMaterialDetail();
    function validatorName($req);
    function addMaterialDetail($request);
    function searchMaterialDetail($request);
    function updateNameMaterialDetail($request,$id);
    function updateTypeMaterialDetail($request,$id);
    function deleteMaterialDetail($id);

}
