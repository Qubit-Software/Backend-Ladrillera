<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoModel extends Model
{
 
    protected $table = 'documentos';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_path', 'nombre', 'tipo_archivo', 'telefono'
    ];

    public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the client that owns the document.
     */
    public function cliente()
    {
        return $this->belongsTo('App\Models\ClienteModel');
    }
}
