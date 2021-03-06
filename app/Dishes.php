<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dishes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dishes';

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
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',     'name',        'image',        'describe',
        'status',        'sale_price',        'capital_price',
        'id_groupnvl',        'id_dvt'
    ];

    public function unit()
    {
        return $this->belongsTo('App\Unit','id_dvt');
    }

    public function material()
    {
        return $this->belongsTo('App\Material','id_groupnvl');
    }

    public function groupMenu()
    {
       return $this->belongsTo('App\GroupMenu','id_groupmenu');
    }

}
