<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\GroupMenu;
use App\Repositories\CookRepository\ICookRepository;
use Illuminate\Http\Request;

class CookController extends Controller
{
    private $cookRepository;

    public function __construct(ICookRepository $cookRepository)
    {
        $this->cookRepository = $cookRepository;
    }

    public function index()
    {
        return $this->cookRepository->getAllCook();
    }

    public function update(Request $request, $id)
    {
        return $this->cookRepository->updateCook($request,$id);
    }
}
