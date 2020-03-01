<?php
namespace App\Repositories\TableRepository;

interface ITableRepository{
    function getAllTable();
    function viewAddTable();
    function addTable($request);
    function viewUpdateTable($id);
    function updateTable($request, $id);
    function deleteTable($id);
    function validatorRequestStore($req);
}
