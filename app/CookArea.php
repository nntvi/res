<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CookArea extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cook_area';

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
        'status'
    ];

    public function groupMenu()
    {
        return $this->hasMany('App\GroupMenu','id_cook');
    }

    public function warehouseCook()
    {
        return $this->hasMany('App\WarehouseCook','cook');
    }
}
