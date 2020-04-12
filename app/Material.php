<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materials';

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
        'name',
        'id_groupmenu'
    ];

    public function materialAction()
    {
        return $this->hasMany('App\MaterialAction','id_groupnvl');
    }

    public function groupMenu()
    {
        return $this->belongsTo('App\GroupMenu','id_groupmenu','id');
    }
}
