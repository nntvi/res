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
        'id_import',
        'id_good',
        'qty',
        'id_unit',
        'price'
    ];

    public function good()
    {
        return $this->belongsTo('App\MaterialDetail','id_good');
    }
}
