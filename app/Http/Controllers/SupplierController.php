<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SupplierRepository\ISupplierRepository;

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
        $types = $this->supplierRepository->getTypeMarial();
        return view('supplier.store',compact('types'));
    }

    public function store(Request $request)
    {
        $this->supplierRepository->validatorRequest($request);
        return $this->supplierRepository->addSupplier($request);
    }

    public function viewUpdate($id)
    {
        return $this->supplierRepository->showViewUpdateSupplier($id);
    }

    public function update(Request $request, $id)
    {
        $this->supplierRepository->validatorRequest($request);
        return $this->supplierRepository->updateSupplier($request,$id);
    }

    public function delete($id)
    {
        return $this->supplierRepository->deleteSupplier($id);
    }
}
