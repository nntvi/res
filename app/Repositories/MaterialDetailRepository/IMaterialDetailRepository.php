<?php
namespace App\Repositories\MaterialDetailRepository;

interface IMaterialDetailRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);

    function getPrice();
    function getTypeMaterial();
    function getUnit();
    function getMaterialDetail();
    function validatorName($req);
    function addMaterialDetail($request);
    function updateNameMaterialDetail($request,$id);
    function updateTypeMaterialDetail($request,$id);
    function deleteMaterialDetail($id);

}
