<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topping';

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
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'price',
        'id_groupmenu'
    ];

    public function groupMenu()
    {
       return $this->belongsTo('App\GroupMenu','id_groupmenu');
    }
}
