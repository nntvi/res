<?php

namespace App;

use App\Permission;
use App\UserPermission;
use App\PermissionDetail;
use App\WarehouseCook;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $timestamps = true;

    public function userPer()
    {
        return $this->hasMany('App\UserPermission','id_user');
    }

    public function userSchedule()
    {
        return $this->hasMany('App\UserSchedule','id_user');
    }

    public function position()
    {
        return $this->belongsTo('App\Position','id_position');
    }

    public function getActionCode($idUser)
    {
        $idperdetails = UserPermission::where( 'id_user', $idUser )->get( 'id_per_detail' ); // list Id Per detai
        $permissionDetails = PermissionDetail::whereIn( 'id', $idperdetails )->get(); // list Per
        $result = array();
        foreach ( $permissionDetails as $perDetail ) {
            array_push( $result, $perDetail->action_code);
        }
        return $result;
    }
    public function checkCook() {
        $result = $this->getActionCode($this->id);
        $roleCook = array();
        foreach ($result as $key => $value) {
            if($value == "VIEW_COOK1" || $value == "VIEW_COOK2" || $value == "VIEW_COOK3"){
                array_push($roleCook,$value);
            }
        }
        return json_encode($roleCook) ?? null;
    }

    public function viewWarehouseCook()
    {
        $result = $this->getActionCode($this->id);
        $roleImportMaterialCook = array();
        foreach ($result as $key => $value) {
           if($value == "VIEW_WHCOOK"){
               array_push($roleImportMaterialCook,$value);
           }
        }
        return json_encode($roleImportMaterialCook);
    }

    public function viewBooking()
    {
        $result = $this->getActionCode($this->id);
        $roleViewBooking = array();
        foreach ($result as $key => $value) {
            if($value == "VIEW_BOOKING"){
                array_push($roleViewBooking,$value);
            }
        }
        return json_encode($roleViewBooking);
    }

    public function notifyQtyOfCook()
    {
        $count = WarehouseCook::selectRaw('count(status) as qty')->where('status','0')->value('qty');
        return $count;
    }
}
