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
        $this->supplierRepository->validateCode($request);
        $this->supplierRepository->validateName($request);
        $this->supplierRepository->validateEmail($request);
        $this->supplierRepository->validatePhone($request);
        $this->supplierRepository->validateStatus($request);
        return $this->supplierRepository->addSupplier($request);
    }

    public function viewUpdate($id)
    {
        return $this->supplierRepository->showViewUpdateSupplier($id);
    }

    public function updateName(Request $request, $id)
    {
        $this->supplierRepository->validateName($request);
        return $this->supplierRepository->updateNameSupplier($request,$id);
    }
    public function update(Request $request, $id)
    {
        $this->supplierRepository->validatePhone($request);
        $this->supplierRepository->validateStatus($request);
        return $this->supplierRepository->updateSupplier($request,$id);
    }

    public function delete($id)
    {
        return $this->supplierRepository->deleteSupplier($id);
    }

    public function search(Request $request)
    {
        $suppliers = $this->supplierRepository->searchSupplier($request);
        $count = $this->supplierRepository->countResultSearch($request);
        return view('supplier.search',compact('suppliers','count'));
    }
}
