<?php
namespace App\Repositories\MaterialRepository;

interface IMaterialRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);

    function getCategoryDish();
    function showMaterial();
    function validatorRequestStore($req);
    function addMaterial($request);
    function validatorRequestUpdate($req);
    function deleteMaterial($id);
    function updateNameMaterial($request, $id);
    function updateGroupMaterial($request, $id);
}
