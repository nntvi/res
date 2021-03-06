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
        return $this->belongsTo(MaterialDetail::class,'id_material_detail')->where('status','1');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit','id_unit','id');
    }

    public function cookArea()
    {
        return $this->belongsTo(CookArea::class,'cook')->where('status','1');
    }
}
