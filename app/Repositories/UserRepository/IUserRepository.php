<?php

namespace App\Repositories\UserRepository;

interface IUserRepository{
    function getAllUser($arr);
    function validatorRequestStore($req);
    function validatorRequestShift($request);
    function updateShiftUser($request,$id);
    function validatorRequestUpdate($req);
    function createUser($req);
    function viewScheduleUser($id);
    function viewUpdate($id);
    function updateUser($req,$id);
    function updatePasswordUser($request, $id);
    function validatorRequestUpdatePassword($req);
    function searchUser($request);
    function deleteUser($id);
}
