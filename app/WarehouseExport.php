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
        'code',
        'id_type',
        'id_object',
        'note',
        'created_by'
    ];

    public function typeExport()
    {
        return $this->belongsTo('App\TypeExport','id_type','id');
    }
}
