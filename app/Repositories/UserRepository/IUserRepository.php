<?php

namespace App\Repositories\UserRepository;

interface IUserRepository{
    function getAllUser($arr);
    function validatorRequestStore($req);
    function validateRequestUpdateUsername($request);
    function validatorRequestShift($request);
    function updateShiftUser($request,$id);
    function createUser($req);
    function viewScheduleUser($id);
    function viewUpdateRole($id);
    function updateRole($req,$id);
    function updatePasswordUser($request, $id);
    function validatorRequestUpdatePassword($req);
    function searchUser($request);
    function deleteUser($id);
    function updateUserName($request ,$id);
    function validatorUpdateRole($request);
    function updatePositionUser($request,$id);
}
