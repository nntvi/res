<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionAction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'per_actions';

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
        'id_per',
        'id_per_detail'
    ];

    public function permissiondetail()
    {
        return $this->belongsTo('App\PermissionDetail','id_per_detail','id');
    }
}
