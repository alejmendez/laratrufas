<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\Orderable;
use App\Traits\Filterable;

class Field extends Model
{
    use HasFactory, Orderable, Filterable;

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function quarters(): HasMany
    {
        return $this->hasMany(Quarter::class);
    }

    public function plants(): HasManyThrough
    {
        return $this->hasManyThrough(Plant::class, Quarter::class);
    }

    public function getCountPlantsAttribute(): int
    {
        return $this->plants->count();
    }

    public function getCountQuartersAttribute(): int
    {
        return $this->quarters->count();
    }
}
