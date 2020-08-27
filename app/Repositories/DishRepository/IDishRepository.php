<?php
namespace App\Repositories\DishRepository;

interface IDishRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);

    function getGroupMenu();
    function getUnit();
    function getMaterialDetail();
    function addDish($request);
    function validatorRequestStore($req);
    function deleteDish($id);
    function getMaterial();
    function updateImageDish($request,$id);
    function validateImage($request);
    function updateSalePriceDish($request,$id);
    function updateUnitDish($request,$id);
    function updateStatusDish($request,$id);
    function updateNoteDish($request,$id);
}
