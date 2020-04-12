<?php
namespace App\Repositories\GroupMenuRepository;

interface IGroupMenuRepository{
    function getAllGroupMenu();
    function addGroupMenu($request);
    function validatorRequestStore($req);
    function validatorRequestUpadate($req);
    function searchGroupMenu($request);
    function deleteGroupMenu($id);
    function updateNameGroupMenu($request, $id);
    function updateCookGroupMenu($request, $id);
}
