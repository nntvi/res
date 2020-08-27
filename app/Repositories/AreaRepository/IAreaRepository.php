<?php
namespace App\Repositories\AreaRepository;

interface IAreaRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);

    function getAllArea();
    function addArea($req);
    function updateArea($req,$id);
    function deleteArea($id);
    function validatorArea($request);
}
