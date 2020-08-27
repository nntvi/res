<?php
namespace App\Repositories\GroupMenuRepository;

interface IGroupMenuRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);

    function getAllGroupMenu();
    function addGroupMenu($request);
    function validatorRequestStore($req);
    function validatorRequestUpadate($req);
    function deleteGroupMenu($id);
    function updateNameGroupMenu($request, $id);
    function updateCookGroupMenu($request, $id);
}
