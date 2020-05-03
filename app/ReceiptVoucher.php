<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptVoucher extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'receipt_voucher';

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
        'code','type_receipt','name','content','total','created_by'
    ];

    public function typeReceipt()
    {
        return $this->belongsTo('App\TypeReceipt','type_receipt','id');
    }

}