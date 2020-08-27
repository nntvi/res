<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingPrice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'setting_price';

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
        'id_material_detail',
        'sltontruoc',
        'giatontruoc',
        'sltonsau',
        'giatonsau'
    ];

    public function detailMaterial()
    {
        return $this->belongsTo('App\MaterialDetail','id_material_detail','id');
    }
}
