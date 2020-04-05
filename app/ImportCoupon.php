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
        'total',
        'note'
    ];

    public function detailImportCoupon()
    {
        return $this->hasMany('App\ImportCouponDetail','code_import','code');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier','id_supplier');
    }
}
