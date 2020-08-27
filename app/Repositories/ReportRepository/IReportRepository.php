<?php
namespace App\Repositories\ReportRepository;

interface IReportRepository{
    function checkRoleIndex($arr);

    function reportOrder($request);
    function reportDish($request);
    function reportDestroyDish($request);
    function getToTalRevenueInYear();
    function getRevenueByMonth($startMonth,$endMonth);
    function getAllRevenue();
    function getAllQtyCustomer();
    function reportSupplier($request);
    function indexReportProfit();
}
