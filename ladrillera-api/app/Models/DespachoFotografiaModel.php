<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DespachoFotografiaModel extends Model
{
    public static $key = 'id';
    protected $table = 'despachos_fotografias';
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pedido',
        'foto',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'id_pedido',
        'foto',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public $timestamps = false;
}
