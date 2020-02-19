<?php
namespace App\Repositories\ToppingRepository;

interface IToppingRepository{
    function getAllGroupMenu();
    function getAllTopping();
    function validatorRequestStore($req);
    function addTopping($request);
    function updateTopping($request,$id);
    function validatorRequestUpdate($req);
    function deleteTopping($id);
}
