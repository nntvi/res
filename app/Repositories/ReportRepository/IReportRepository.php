<?php
namespace App\Repositories\ReportRepository;

interface IReportRepository{
    function reportOrder($request);
    function reportTable($request);
    function reportDish($request);
    function getToTalRevenueInYear();
    function getRevenueByMonth($startMonth,$endMonth);
    function getAllRevenue();
    function getAllQtyCustomer();
    function createChartDishByTime($dateStart,$dateEnd);
}
