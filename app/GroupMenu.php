<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'groupmenu';

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
        'name'
    ];

    public function cookArea()
    {
        return $this->belongsTo('App\CookArea','id_cook');
    }

    public function topping()
    {
        return $this->hasMany('App\Topping','id_groupmenu');
    }

    public function material()
    {
        return $this->hasMany('App\Material','id_groupmenu');
    }

    public function dishes()
    {
        return $this->hasMany(Dishes::class,'id_groupmenu')->where('stt','1')->where('status','1');
    }
}
