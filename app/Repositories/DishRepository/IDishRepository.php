<?php
namespace App\Repositories\DishRepository;

interface IDishRepository{
    function getGroupMenu();
    function getUnit();
    function getMaterialDetail();
    function addDish($request);
    function showUpdateDish($id);
    function updateDish($request, $id);
    function searchDish($request);
    function validatorRequestStore($req);
    function deleteDish($id);
    function validatorRequestUpdate($req);
    function validatorRequestSearch($req);
    function getMaterial();
}
