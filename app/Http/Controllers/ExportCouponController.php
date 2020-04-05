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
        //return $this->exportcouponRepository->showViewExport();
    }

    public function export(Request $request)
    {
        return $this->exportcouponRepository->exportMaterial($request);
    }

    public function getDetail($id)
    {
        return $this->exportcouponRepository->getDetailExport($id);
    }

    public function printDetail($id)
    {
        return $this->exportcouponRepository->printDetailExport($id);
    }
}
