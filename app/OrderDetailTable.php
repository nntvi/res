<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetailTable extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detail_order_table';

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
        'id_bill',
        'id_dish',
        'qty',
        'status',
        'price'
    ];

    public function dish()
    {
        return $this->belongsTo('App\Dishes','id_dish');
    }

    public function order()
    {
        return $this->belongsTo('App\Order','id_bill');
    }
}
