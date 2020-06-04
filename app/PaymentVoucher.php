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
        'name',     'code',     'type',     'name',
        'pay_cash',     'note',     'created_by'
    ];
}
