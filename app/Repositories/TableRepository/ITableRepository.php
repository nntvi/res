<?php
namespace App\Repositories\TableRepository;

interface ITableRepository{
    function getAllTable();
    function addTable($request);
    function updateNameTable($request,$id);
    function updateArea($request,$id);
    function deleteTable($id);
    function validatorRequestStore($req);
    function searchTable($request);
}
