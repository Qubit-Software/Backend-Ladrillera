<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class ActualizacionModel extends Model
{
    public static $key = 'id';
    protected $primaryKey = 'id';
    protected $table = 'actualizaciones';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "titulo",
        "descripcion",
        "fecha",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        "titulo",
        "descripcion",
        "fecha",
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha'];

    public $timestamps = false;

    /**
     * Get the user's first name.
     *
     * @param  date  $value
     * @return date
     */
    public function getFechaAttribute($value)
    {
        return date('Y-m-d', strtotime($value === NULL ? '' : $value));
    }
    /**
     * Get the user's first name.
     *
     * @param  date  $value
     * @return date
     */
    public function setFechaAttribute($value)
    {
        $string_date = ($value instanceof DateTime) ? $value->format('Y-m-d') :  $value;
        $this->attributes['fecha'] = date('Y-m-d', strtotime($string_date === NULL ? '' : $string_date));
    }
}
