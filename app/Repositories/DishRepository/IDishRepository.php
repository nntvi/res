<?php
namespace App\Repositories\DishRepository;

interface IDishRepository{
    function getGroupMenu();
    function getUnit();
    function getMaterialDetail();
    function addDish($request);
    function searchDish($request);
    function validatorRequestStore($req);
    function deleteDish($id);
    function validatorRequestSearch($req);
    function getMaterial();
    function updateImageDish($request,$id);
    function validateImage($request);
    function updateSalePriceDish($request,$id);
    function updateUnitDish($request,$id);
    function updateStatusDish($request,$id);
}
