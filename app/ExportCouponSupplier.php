<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExportCouponSupplier extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'export_coupon_supplier';

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
        'total',
        'note',
        'created_by'
    ];

    public function detailExportSupplier()
    {
        return $this->hasMany('App\ExportCouponSupplierDetail','id_exsupplier','id');
    }

    public function importCoupon()
    {
        return $this->belongsTo('App\ImportCoupon','id_coupon','id');
    }
}
