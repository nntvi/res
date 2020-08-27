<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucherDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detail_payment_voucher';

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
        'id_paymentvc',
        'id_material_detail',
        'qty'
    ];

    public function detailMaterial()
    {
        return $this->belongsTo('App\MaterialDetail','id_material_detail','id');
    }
}
