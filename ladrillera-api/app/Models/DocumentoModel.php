<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoModel extends Model
{
 
    protected $primaryKey = 'id';
    protected $table = 'documentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_path', 'nombre', 'tipo_documento', 'id_cliente'
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
        return $this->belongsTo('App\Models\ClienteModel', 'id_cliente');
    }
}
