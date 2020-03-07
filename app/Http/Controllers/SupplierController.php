<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SupplierRepository\ISupplierRepository;
use App\Supplier;

class SupplierController extends Controller
{
    private $supplierRepository;

    public function __construct(ISupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function index()
    {
        return $this->supplierRepository->getAllSupplier();
    }

    public function viewStore()
    {
        return view('supplier.store');
    }

    public function store(Request $request)
    {
        $this->supplierRepository->validatorRequestStore($request);
        return $this->supplierRepository->addSupplier($request);
    }

    public function viewUpdate($id)
    {
        return $this->supplierRepository->showViewUpdateSupplier($id);
    }

    public function update(Request $request, $id)
    {
        $this->supplierRepository->validatorRequestUpdate($request);
        return $this->supplierRepository->updateSupplier($request,$id);
    }

    public function delete($id)
    {
        return $this->supplierRepository->deleteSupplier($id);
    }
}