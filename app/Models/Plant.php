<?php

namespace App\Models;

use App\Models\Quarter;
use App\Models\PlantType;
use App\Traits\Orderable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plant extends Model
{
    use Filterable, HasFactory, Orderable;

    public function quarter(): BelongsTo
    {
        return $this->belongsTo(Quarter::class);
    }

    public function plant_type(): BelongsTo
    {
        return $this->belongsTo(PlantType::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function harvest_details(): HasMany
    {
        return $this->hasMany(HarvestDetail::class);
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper(trim($value)),
            set: fn (string $value) => strtoupper(trim($value)),
        );
    }
}
