<?php
namespace App\Repositories\GroupMenuRepository;

interface IGroupMenuRepository{
    function getAllGroupMenu();
    function addGroupMenu($request);
    function validatorRequestStore($req);
    function validatorRequestSearch($req);
    function searchGroupMenu($request);
    function updateGroupMenu($request, $id);
    function validatorRequestUpadate($req);
    function deleteGroupMenu($id);
}
