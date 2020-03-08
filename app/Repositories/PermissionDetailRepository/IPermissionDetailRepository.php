<?php
namespace App\Repositories\PermissionDetailRepository;

interface IPermissionDetailRepository{
    function showAllDetail();
    function convertActionCode($str);
    function deleteDetail($id);
    function validatorRequestStore($req);
}
