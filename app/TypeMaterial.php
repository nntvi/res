<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeMaterial extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_material';

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

    public function materialDetail()
    {
        return $this->hasMany('App\MaterialDetail','id_type');
    }

    public function warehouse()
    {
        return $this->hasMany('App\Warehouse','id_type');
    }
}
