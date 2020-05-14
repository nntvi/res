<?php

namespace App\Http\Controllers;

use App\Repositories\ExportCouponRepository\IExportCouponRepository;
use Illuminate\Http\Request;

class ExportCouponController extends Controller
{
    private $exportcouponRepository;

    public function __construct(IExportCouponRepository $exportcouponRepository)
    {
        $this->exportcouponRepository = $exportcouponRepository;
    }
    public function index()
    {
        return $this->exportcouponRepository->showIndex();
    }
    public function viewExport(Request $request)
    {
        return $this->exportcouponRepository->showViewExport($request);
    }

    public function export(Request $request)
    {
        $this->exportcouponRepository->validateExport($request);
        return $this->exportcouponRepository->exportMaterial($request);
    }

    public function exportSupplier(Request $request)
    {
        return $this->exportcouponRepository->exportSupplier($request);
    }
    public function getDetail($id)
    {
        return $this->exportcouponRepository->getDetailExport($id);
    }

    public function printDetail($id)
    {
        return $this->exportcouponRepository->printDetailExport($id);
    }

    public function viewDestroyWarehouse()
    {
        return view('warehouseexport.exportdestroy');
    }

    public function destroyWarehouse(Request $request)
    {
        return $this->exportcouponRepository->destroyWarehouse($request);
    }

    public function viewDestroyWarehouseCook($id)
    {
        return $this->exportcouponRepository->viewDestroyCook($id);
    }
    public function destroyWarehouseCook(Request $request)
    {
        return $this->exportcouponRepository->destroyCook($request);
    }
}
