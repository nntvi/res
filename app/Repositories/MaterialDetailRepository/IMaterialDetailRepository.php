<?php
namespace App\Repositories\MaterialDetailRepository;

interface IMaterialDetailRepository{
    function showMaterialDetail();
    function validatorRequestStore($req);
    function addMaterialDetail($request);
}
