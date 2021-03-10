<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    // ? Campos
    protected $fillable = [
        'titulo', 'categoria_id', 'ingredientes', 'preparacion', 'imagen', 'user_id'
    ];


    // ? Relacion de Categoria
    public function categoria()
    {
        return $this->belongsTo(CategoriaReceta::class);
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The roles that belong to the Receta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes_receta');
    }
}
