<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaReceta extends Model
{
    // ? Relacion de recetas
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }
}
