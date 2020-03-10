<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WareHouseDetail extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detail_warehouse';

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
        'code',
        'id_material_detail',
        'id_unit',
        'qty',
        'price',
    ];

    public function materialDetail()
    {
        return $this->belongsTo('App\MaterialDetail','id_material_detail','id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit','id_unit','id');
    }
}
