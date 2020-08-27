<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equation';

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
        'textTuso',
        'textMauso',
        'tuso',
        'mauso',
        'result',
        'status'
    ];
}
