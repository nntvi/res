<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialAction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'material_action';

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
        'id_groupnvl',
        'id_material_detail',
        'id_dvt',
        'qty',
    ];

    public function materialDetail()
    {
        return $this->belongsTo('App\MaterialDetail','id_material_detail','id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit','id_dvt','id');
    }

    public function material()
    {
        return $this->belongsTo('App\Material','id_groupnvl','id');
    }
}
