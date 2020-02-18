<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupMenu;
use App\Repositories\GroupMenuRepository\IGroupMenuRepository;

class GroupMenuController extends Controller
{
    private $groupmenuRepository;

    public function __construct(IGroupMenuRepository $groupmenuRepository)
    {
        $this->groupmenuRepository = $groupmenuRepository;
    }

    public function index()
    {
        return $this->groupmenuRepository->getAllGroupMenu();
    }
    public function store(Request $request)
    {
        $this->groupmenuRepository->validatorRequestStore($request);
        return $this->groupmenuRepository->addGroupMenu($request);
    }
    public function search(Request $request)
    {
        $this->groupmenuRepository->validatorRequestSearch($request);
        return $this->groupmenuRepository->searchGroupMenu($request);
    }
    public function update(Request $request, $id)
    {
        $this->groupmenuRepository->validatorRequestUpadate($request);
        return  $this->groupmenuRepository->updateGroupMenu($request,$id);
    }
    public function delete($id)
    {

    }
}
