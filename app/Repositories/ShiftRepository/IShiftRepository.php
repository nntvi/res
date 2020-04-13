<?php
namespace App\Repositories\ShiftRepository;

interface IShiftRepository{
    function showIndex();
    function validateUnique($request);
    function storeShift($request);
    function updateNameShift($request, $id);
    function updateTimeShift($request,$id);
    function deleteShift($id);
}
