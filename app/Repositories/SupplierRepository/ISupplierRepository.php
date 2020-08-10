<?php
namespace App\Repositories\SupplierRepository;

interface ISupplierRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);

    function getTypeMarial();
    function getAllSupplier();
    function addSupplier($request);
    function showViewUpdateSupplier($id);
    function updateNameSupplier($request,$id);
    function updateSupplier($request,$id);
    function deleteSupplier($id);
    function validateCode($request);
    function validateName($request);
    function validateEmail($request);
    function validatePhone($request);
    function validateStatus($request);
}
