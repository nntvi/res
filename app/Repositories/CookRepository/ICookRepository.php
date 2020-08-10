<?php
namespace App\Repositories\CookRepository;

interface ICookRepository{
    function checkRoleIndex($arr);
    function checkRoleUpdate($arr);

    function getAllCook();
    function updateCook($request, $id);
    function findCookById($id);
    //function getGroupMenuByIdCook($idcook);
}
