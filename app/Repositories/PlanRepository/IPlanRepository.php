<?php
namespace App\Repositories\PlanRepository;

interface IPlanRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);

    function getToday();
    function getSuppliers();
    function getPlan();
    function validateStore($request);
    function storePlan($request);
    function getDetailPlan($id,$idSupplier);
    function postDetailPlan($request);
}
