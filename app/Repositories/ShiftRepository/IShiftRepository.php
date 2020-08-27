<?php
namespace App\Repositories\ShiftRepository;

interface IShiftRepository{
    function checkRoleIndex($arr);

    function showIndex();
    function validateUnique($request);
    function storeShift($request);
    function updateNameShift($request, $id);
    function updateTimeShift($request,$id);
}
