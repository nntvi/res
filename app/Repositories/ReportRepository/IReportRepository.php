<?php
namespace App\Repositories\ReportRepository;

interface IReportRepository{
    function reportOrder($request);
    function reportTable($request);
    function reportDish($request);
    function getToTalRevenueInYear();
    function getMonthInYear();
}
