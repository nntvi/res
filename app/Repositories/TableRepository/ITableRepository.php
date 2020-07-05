<?php
namespace App\Repositories\TableRepository;

interface ITableRepository{
    function getAllTable();
    function addTable($request);
    function updateNameTable($request,$id);
    function updateAreaTable($request,$id);
    function updateChair($request,$id);
    function deleteTable($id);
    function validateCodeTable($request);
    function validatorNameTable($req);
    function searchTable($request);
}
