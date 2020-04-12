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
    public function search(Request $request)
    {
        return $this->toppingRepository->searchTopping($request);
    }
    public function store(Request $request)
    {
        $this->toppingRepository->validatorRequestStore($request);
        return $this->toppingRepository->addTopping($request);
    }
    public function updateName(Request $request,$id)
    {
        $this->toppingRepository->validatorRequestUpdateName($request);
        return $this->toppingRepository->updateNameTopping($request,$id);
    }
    public function updatePrice(Request $request,$id)
    {
        return $this->toppingRepository->updatePriceTopping($request,$id);
    }
    public function updateGroup(Request $request,$id)
    {
        return $this->toppingRepository->updateGroupTopping($request,$id);
    }
    public function delete($id)
    {
        return $this->toppingRepository->deleteTopping($id);
    }
}
