<?php
namespace App\Repositories\CookRepository;

interface ICookRepository{
    function getAllCook();
    function updateCook($request, $id);
    function findCookById($id);
    function getGroupMenuByIdCook($idcook);
}
