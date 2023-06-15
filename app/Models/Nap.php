<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Nap extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nro',
        'address',
        'subsector_id',
        'sector_id'
    ];

    public function Subsector(): BelongsTo
    {
        return $this->belongsTo(SubSector::class);
    }
    public function Sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
    public function Parroquia(): BelongsTo
    {
        return $this->belongsTo(Parroquia::class);
    }
}
