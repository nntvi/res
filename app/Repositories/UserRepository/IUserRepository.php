<?php

namespace App\Repositories\UserRepository;

interface IUserRepository{
    function getAllUser($arr);
    function validatorRequestStore($req);
    function validatorRequestUpdate($req);
    function createUser($req);
    function viewUpdate($id);
    function updateUser($req,$id);
    function deleteUser($id);
}
