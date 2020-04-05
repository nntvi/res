<?php
namespace App\Repositories\ImportCouponRepository;

interface IImportCouponRepository{
    function getListImport();
    function getSuppliers();
    function getMaterialDetail();
    function getUnit();
    function getTypeMaterial();
    function getOldQty($i,$request);
    function showIndex();
    function showViewImport();
    function countMaterialImport($request);
    function createImportCouponDetail($request,$i);
    function getTotalDetailImportCoupon($detailImports);
    function createImportCoupon($request);
    function import($request);
    function findDetailImportCouponByIdImport($id);
    function getDetailImportCouponById($id);
    function updateDetailImportCoupon($request,$id);
    function findImportCouponByCode($code);
    function findDetailImportCouponByCode($code);
    function printDetailByCode($code);
}
