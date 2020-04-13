<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExportCoupon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'export_coupons';

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
        'note'
    ];

    public function detailExportCoupon()
    {
        return $this->hasMany('App\ExportCouponDetail','code_export','code');
    }

    public function typeExport()
    {
        return $this->belongsTo('App\TypeExport','id_type');
    }
}
