<?php
namespace App\Repositories\SupplierRepository;

interface ISupplierRepository{
    function getTypeMarial();
    function getAllSupplier();
    function validatorRequest($req);
    function addSupplier($request);
    function showViewUpdateSupplier($id);
    function updateSupplier($request,$id);
    function deleteSupplier($id);
}
