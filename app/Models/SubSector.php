<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class SubSector extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sector_id'
    ];
    protected $table = 'subsectors';

    public function naps(): HasMany
    {
        return $this->hasMany(Nap::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
