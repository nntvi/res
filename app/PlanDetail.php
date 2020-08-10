<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanDetail extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detail_plan';

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
        'id_plan',
        'id_material_detail',
    ];

    public function materialDetail()
    {
        return $this->belongsTo('App\MaterialDetail','id_material_detail');
    }
}
