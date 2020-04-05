<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'material_details';

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

    public function typeMaterial()
    {
        return $this->belongsTo('App\TypeMaterial','id_type');
    }

}
