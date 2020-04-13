<?php
namespace App\Repositories\MaterialRepository;

interface IMaterialRepository{
    function getCategoryDish();
    function showMaterial();
    function validatorRequestStore($req);
    function addMaterial($request);
    function validatorRequestUpdate($req);
    function searchMaterial($request);
    function deleteMaterial($id);
    function updateNameMaterial($request, $id);
    function updateGroupMaterial($request, $id);
}
