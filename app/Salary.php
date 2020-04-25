<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'salary';

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
        'id_position','salary'
    ];

    public function permission()
    {
        return $this->belongsTo('App\Permission','id_position','id');
    }
}
