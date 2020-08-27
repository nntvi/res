<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SupplierRepository\ISupplierRepository;
use App\Helper\ICheckAction;

class SupplierController extends Controller
{
    private $supplierRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, ISupplierRepository $supplierRepository)
    {
        $this->checkAction = $checkAction;
        $this->supplierRepository = $supplierRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->supplierRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->supplierRepository->getAllSupplier();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function viewStore()
    {
        $types = $this->supplierRepository->getTypeMarial();
        return view('supplier.store',compact('types'));
    }

    public function store(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->supplierRepository->checkRoleStore($result);
        if($check != 0){
            $this->supplierRepository->validateCode($request);
            $this->supplierRepository->validateName($request);
            $this->supplierRepository->validateEmail($request);
            $this->supplierRepository->validatePhone($request);
            $this->supplierRepository->validateStatus($request);
            //return $this->supplierRepository->addSupplier($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function viewUpdate($id)
    {
        return $this->supplierRepository->showViewUpdateSupplier($id);
    }

    public function updateName(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->supplierRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->supplierRepository->validateName($request);
            return $this->supplierRepository->updateNameSupplier($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function update(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->supplierRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->supplierRepository->validatePhone($request);
            $this->supplierRepository->validateStatus($request);
            return $this->supplierRepository->updateSupplier($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function delete($id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->supplierRepository->checkRoleDelete($result);
        if($check != 0){
            return $this->supplierRepository->deleteSupplier($id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

}
