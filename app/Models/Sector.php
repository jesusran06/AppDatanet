<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parroquia_id'
    ];
    protected $table = 'sectors';
    
    public function subsectors(): HasMany
    {
        return $this->hasMany(SubSector::class);
    }

    public function parroquia(): BelongsTo
    {
        return $this->belongsTo(Parroquia::class);
    }
}
