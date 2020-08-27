<?php
namespace App\Repositories\ImportCouponRepository;

interface IImportCouponRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);

    function getSuppliers();
    function getNameSupplierById($idSupplier);
    function getMaterialDetail();
    function getUnit();
    function getTypeMaterial();
    function getOldQty($i,$request);
    function showIndex();
    function showViewImport();
    function showViewImportPlan();
    function countMaterialImport($request);
    function createImportCouponDetail($request,$i,$idImportCoupon);
    function getTotalDetailImportCoupon($detailImports);
    function createImportCoupon($request);
    function import($request);
    function findDetailImportCouponByIdImport($id);
    function getDetailImportCouponById($id);
    function updateDetailImportCoupon($request,$id);
    function findImportCouponByCode($code);
    function findDetailImportCouponByCode($code);
    function printDetailByCode($code);
    function validateCreatImportCoupon($request);
    function validateCreatImportCouponPlan($request);

    function createArrayChooseMaterial($arrIdMaterial);
}
