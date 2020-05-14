<?php
namespace App\Helper;

use App\User;
use App\UserPermission;
use App\Permission;
use App\PermissionAction;
use App\PermissionDetail;
use App\Helper\ICheckAction;
use App\Helper\ActionRespository;
use Carbon\Carbon;

class CheckAction implements ICheckAction {

    public function getPermission( $id ) {
        $idperdetails = UserPermission::where( 'id_user', $id )->get( 'id_per_detail' ); // list Id Per detai
        $permissionDetails = PermissionDetail::whereIn( 'id', $idperdetails )->get(); // list Per
        $result = array();
        foreach ( $permissionDetails as $perDetail ) {
            array_push( $result, $perDetail->action_code);
        }
        return $result;
    }
}
