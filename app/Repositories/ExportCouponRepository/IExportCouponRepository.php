<?php
namespace App\Repositories\ExportCouponRepository;

interface IExportCouponRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);

    function validateExport($request);
    function showViewExport($request);
    function exportMaterial($request);
    function exportSupplier($request);
    function showIndex();
    function getDetailExport($id);
    function printDetailExport($id);
    function destroyWarehouse($request);
    function viewDestroyCook($id);
    function destroyCook($request);
    function createCode($random_string);

    function getDetailExportSupplier($id);
}
