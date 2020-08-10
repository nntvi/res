<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExportCouponSupplierDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'export_coupon_supplier_dt';

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
        'name',
        'id_exsupplier',
        'id_material_detail',
        'qty',
        'price',
    ];

    public function importCoupon()
    {
        return $this->belongsTo('App\ImportCoupon','code_imcoupon','code_import');
    }

    public function materialDetail()
    {
        return $this->belongsTo('App\MaterialDetail','id_material_detail','id');
    }

}
