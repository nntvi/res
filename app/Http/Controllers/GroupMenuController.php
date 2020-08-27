<?php
namespace App\Validations;
namespace App\Http\Controllers;
use App\CookArea;
use Illuminate\Http\Request;
use App\Repositories\GroupMenuRepository\IGroupMenuRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GroupMenuExport;
use App\Helper\ICheckAction;
class GroupMenuController extends Controller
{
    private $groupmenuRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IGroupMenuRepository $groupmenuRepository)
    {
        $this->checkAction = $checkAction;
        $this->groupmenuRepository = $groupmenuRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->groupmenuRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->groupmenuRepository->getAllGroupMenu();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function viewStore()
    {
        $cooks = CookArea::all();
        $cook_active = array();
        foreach ($cooks as $key => $cook) {
            if($cook->status != '0'){
                $cook_active[] = $cook;
            }
        }
        return view('groupmenu.store',compact('cook_active'));
    }

    public function store(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->groupmenuRepository->checkRoleStore($result);
        if($check != 0){
            $this->groupmenuRepository->validatorRequestStore($request);
            return $this->groupmenuRepository->addGroupMenu($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateName(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->groupmenuRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->groupmenuRepository->validatorRequestUpadate($request);
            return $this->groupmenuRepository->updateNameGroupMenu($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }
    public function updateCook(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->groupmenuRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->groupmenuRepository->validatorRequestUpadate($request);
            return $this->groupmenuRepository->updateCookGroupMenu($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function delete($id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->groupmenuRepository->checkRoleDelete($result);
        if($check != 0){
            return $this->groupmenuRepository->deleteGroupMenu($id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }
}
