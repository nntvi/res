<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ToppingRepository\IToppingRepository;

class ToppingController extends Controller
{
    private $toppingRepository;

    public function __construct(IToppingRepository $toppingRepository)
    {
        $this->toppingRepository = $toppingRepository;
    }
    public function index()
    {
        $toppings = $this->toppingRepository->getAllTopping();
        $groupMenus = $this->toppingRepository->getAllGroupMenu();
        return view('topping.index',compact('groupMenus','toppings'));
    }

    public function store(Request $request)
    {
        $this->toppingRepository->validatorRequestStore($request);
        return $this->toppingRepository->addTopping($request);
    }

    public function update(Request $request, $id)
    {
        $this->toppingRepository->validatorRequestUpdate($request);
        return $this->toppingRepository->updateTopping($request,$id);
    }

    public function delete($id)
    {
        return $this->toppingRepository->deleteTopping($id);
    }
}
