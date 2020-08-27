<?php
namespace App\Repositories\PlanRepository;

interface IPlanRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function checkRoleUpdate($arr);
    function checkRoleDelete($arr);
    function getDateCreate($id);


    function createTempArrayMaterialPlan($request);
    function saveStore($request,$idPlan);
    function getNameSupplierByIdPlan($idPlan);
    function updateQtyMaterial($request,$idPlan,$idMaterial);

    function getStatusPlan($id);
    function getToday();
    function getSuppliers();
    function getPlan();
    function validateStore($request);
    function storePlan($request);
    function getDetailPlan($id);
    function postDetailPlan($request);
}
