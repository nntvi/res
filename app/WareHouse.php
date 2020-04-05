<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'warehouse';

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
        'id_type',
        'id_material_detail',
        'qty',
        'id_unit'
    ];

    public function detailMaterial()
    {
        return $this->belongsTo('App\MaterialDetail','id_material_detail','id');
    }

    public function typeMaterial()
    {
        return $this->belongsTo('App\TypeMaterial','id_type','id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit','id_unit','id');
    }

    public function import()
    {
        return $this->hasMany('App\ImportCouponDetail','id_material_detail','id_material_detail');
    }
}
