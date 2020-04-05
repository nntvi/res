<?php
namespace App\Repositories\MaterialActionRepository;

interface IMaterialActionRepository{
    function getAllMaterials();
    function getMaterialById($id);
    function getMaterialDetails();
    function getUnit();
    function findMaterialById($id);
    function findMaterialActionById($id);
    function findRowMaterialAction($id);
    function countMaterialRequest($request);
    function showIndex();
    function viewStoreMaterialAction($id);
    function addOneByOneMaterialAction($count,$request);
    function storeMaterialAction($request,$id);
    function showMoreDetailById($id);
    function showViewUpdateMaterialAction($id);
    function updateMaterialAction($request,$id);
    function deleteMaterialAction($id);
}
