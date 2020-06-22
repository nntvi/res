<?php
namespace App\Repositories\AreaRepository;

interface IAreaRepository{
    function getAllArea();
    function addArea($req);
    function updateArea($req,$id);
    function deleteArea($id);
    function validatorArea($request);
}
