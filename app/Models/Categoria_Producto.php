<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_Producto extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_categoria_productos';
    protected $table = 'categoria_productos';
    public $timestamps = false;
}
