<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSchedule extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_schedule';

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
        'id_user','id_weekday','id_shift'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','id_user');
    }

    public function weekday()
    {
        return $this->belongsTo('App\Weekdays','id_weekday');
    }

    public function shift()
    {
        return $this->belongsTo('App\Shift','id_shift');
    }
}
