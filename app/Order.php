<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_table';

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
        'id_table',
        'status',
        'total_price',
        'note',
        'receive_cash',
        'excess_cash',
        'created_by',
        'id_shift'
    ];

    public function orderDetail()
    {
        return $this->hasMany('App\OrderDetailTable','id_bill');
    }

    public function table()
    {
        return $this->belongsTo('App\Table','id_table');
    }

    public function user()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function shift()
    {
        return $this->belongsTo('App\Shift','id_shift');
    }
}
