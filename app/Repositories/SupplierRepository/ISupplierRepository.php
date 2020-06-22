<?php
namespace App\Repositories\SupplierRepository;

interface ISupplierRepository{
    function getTypeMarial();
    function getAllSupplier();
    function addSupplier($request);
    function showViewUpdateSupplier($id);
    function updateNameSupplier($request,$id);
    function updateSupplier($request,$id);
    function deleteSupplier($id);
    function countResultSearch($request);
    function searchSupplier($request);
    function validateCode($request);
    function validateName($request);
    function validateEmail($request);
    function validatePhone($request);
    function validateStatus($request);
}
