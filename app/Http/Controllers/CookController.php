<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\GroupMenu;
use App\Repositories\CookRepository\ICookRepository;
use Illuminate\Http\Request;
use App\Helper\ICheckAction;
class CookController extends Controller
{
    private $cookRepository;
    private $checkAction;
    public function __construct(ICheckAction $checkAction, ICookRepository $cookRepository)
    {
        $this->checkAction = $checkAction;
        $this->cookRepository = $cookRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->cookRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->cookRepository->getAllCook();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function update(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->cookRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->cookRepository->updateCook($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }
}
