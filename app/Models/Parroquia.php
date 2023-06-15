<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Parroquia extends Model
{
    use HasFactory;
    protected $table = 'parroquias';
    protected $filliable = ['id', 'id_municipio', 'parroquia'];

    public function sectors(): HasMany
    {
        return $this->hasMany(Sector::class);
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }
}
