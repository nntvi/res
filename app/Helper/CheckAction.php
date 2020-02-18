<?php
namespace App\Helper;

use App\User;
use App\UserPermission;
use App\Permission;
use App\PermissionAction;
use App\PermissionDetail;
use App\Helper\ICheckAction;
use App\Helper\ActionRespository;

class CheckAction implements ICheckAction {

    public function getPermission( $id ) {

        $idpermissions = UserPermission::where( 'id_user', $id )->get( 'id_per' ); // list Id Per

        $permissions = Permission::whereIn( 'id', $idpermissions )->get(); // list Per

        $result = array();
        foreach ( $permissions as $permission ) {
            $peractions = $permission->peraction;
          //  dd($peractions);
            if ($peractions) {
                foreach ( $peractions as $peraction ) {
                    echo $peraction->id_per_detail;
                    $per_detail = PermissionDetail::where('id', $peraction->id_per_detail )->first('action_code');
                    array_push( $result, $per_detail);
                }
            }
        }
        return $result;
    }
}
