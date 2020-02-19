<?php
namespace App\Repositories\SupplierRepository;

interface ISupplierRepository{
    function getAllSupplier();
    function validatorRequestStore($req);
    function addSupplier($request);
    function showViewUpdateSupplier($id);
    function updateSupplier($request,$id);
    function validatorRequestUpdate($req);
    function deleteSupplier($id);
}
