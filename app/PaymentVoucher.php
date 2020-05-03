<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_voucher';

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
        'code','type_payment','name','content','total','created_by'
    ];

    public function typePayment()
    {
        return $this->belongsTo('App\TypePayment','type_payment','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','created_by','id');
    }
}
