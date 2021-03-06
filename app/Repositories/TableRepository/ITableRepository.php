<?php
namespace App\Repositories\TableRepository;

interface ITableRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);

    function getAllTable();
    function addTable($request);
    function updateNameTable($request,$id);
    function updateAreaTable($request,$id);
    function updateChair($request,$id);
    function deleteTable($id);
    function validateCodeTable($request);
    function validateNameTable($req);
}
