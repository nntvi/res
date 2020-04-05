<?php
namespace App\Repositories\MaterialRepository;

interface IMaterialRepository{
    function getCategoryDish();
    function showMaterial();
    function validatorRequestStore($req);
    function addMaterial($request);
    function validatorRequestUpdate($req);
    function updateMaterial($request,$id);
    function deleteMaterial($id);
}
