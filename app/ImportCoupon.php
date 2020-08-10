<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportCoupon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'import_coupons';

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
        'id_supplier',
        'total',
        'paid',
        'status',
        'note'
    ];

    public function detailImportCoupon()
    {
        return $this->hasMany('App\ImportCouponDetail','id_imcoupon','id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier','id_supplier');
    }

    public function exportSupplier()
    {
        return $this->hasMany('App\ExportCouponSupplier','id_coupon','id');
    }
}
