<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeekDays extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weekdays';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];


}
