<?php
namespace App\Repositories\ToppingRepository;

interface IToppingRepository{
    function getAllGroupMenu();
    function getAllTopping();
    function validatorRequestStore($req);
    function addTopping($request);
    function validatorRequestUpdateName($req);
    function deleteTopping($id);
    function updateNameTopping($request,$id);
    function updatePriceTopping($request,$id);
    function updateGroupTopping($request,$id);
}
