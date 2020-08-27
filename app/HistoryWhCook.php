<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryWhCook extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'history_whcook';

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
        'id_cook',
        'id_material_detail',
        'first_qty',
        'last_qty',
        'id_unit',
    ];

    public function detailMaterial()
    {
        return $this->belongsTo('App\MaterialDetail','id_material_detail','id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit','id_unit','id');
    }

    public function cook()
    {
        return $this->belongsTo('App\Unit','id_cook','id');
    }
}
