<?php
namespace App\Repositories\PositionRepository;

interface IPositionRepository{
    function show();
    function validateNamePosition($request);
    function storePosition($request);
    function updateNamePosition($request,$id);
    function updateSalaryPosition($request,$id);
    function deletePosition($id);
}
