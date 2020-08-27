<?php

namespace App\Repositories\PermissionRepository;

interface IPermissionRepository{
    function showAllPermission();
    function validatorRequestStore($req);
    function addPermission($req);
    function getPermissionDetail();
    function findPermission($id);
    function getPerActionById($id);
    function getOldPerDetail($permissiondetails,$peractions);
    function updatePermission($req, $permission);
    function deletePermission($id);
    function updateName($request,$id);
    function validateUpdateName($request);
    function validateUpdateDetail($req);
}
