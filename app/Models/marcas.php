<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marcas extends Model
{
    use HasFactory;

    protected $table = 'marcas'; // Nombre de la tabla en la base de datos

    protected $primaryKey = 'idma'; // Clave primaria

    protected $fillable = [
        'nombre_marca',
        'descripcion',
        'archivo' // Este campo almacena la ruta del logo de la marca
    ];
}
