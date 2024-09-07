<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper(trim($value)),
            set: fn (string $value) => strtoupper(trim($value)),
        );
    }
}
