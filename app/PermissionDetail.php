<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionDetail extends Model
{
    // public function permission()
    // {
    //     return $this->belongsTo('App\Permission','id_per');
    // }
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission__details';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'action_code'
    ];

}
