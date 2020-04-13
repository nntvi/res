<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseCook extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'warehouse_cook';

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
        'cook',
        'id_material_detail',
        'qty',
        'id_unit'
    ];

    public function detailMaterial()
    {
        return $this->belongsTo('App\MaterialDetail','id_material_detail','id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit','id_unit','id');
    }
}
