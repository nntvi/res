<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseExport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'warehouse_export';

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
        'qty',
        'unit',
    ];

    public function cook()
    {
        return $this->belongsTo('App\CookArea','id_cook','id');
    }
}
