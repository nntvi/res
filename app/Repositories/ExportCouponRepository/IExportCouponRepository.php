<?php
namespace App\Repositories\ExportCouponRepository;

interface IExportCouponRepository{
    function showViewExport($request);
    function exportMaterial($request);
    function showIndex();
    function getDetailExport($id);
    function printDetailExport($id);
}
