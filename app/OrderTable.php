<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTable extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tables_ordered';

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
        'id_order',
        'id_table',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order','id_order','id');
    }

    public function table()
    {
        return $this->belongsTo('App\Table','id_table','id');
    }

}
