<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plan';

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
        'date_create',
        'id_supplier',
        'note',
        'status',
        'created_by'
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier','id_supplier');
    }

    public function detailPlan()
    {
        return $this->hasMany('App\PlanDetail','id_plan');
    }
}
