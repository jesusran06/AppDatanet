<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;
    protected $table = 'municipios';
    protected $filliable = ['id', 'id_estado', 'municipio'];

    public function parroquias(): HasMany
    {
        return $this->hasMany(Parroquia::class);
    }
}
