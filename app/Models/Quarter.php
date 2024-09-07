<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quarter extends Model
{
    use Filterable, HasFactory, Orderable;

    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function getCountPlantsAttribute(): int
    {
        return $this->plants->count();
    }

    public function harvests()
    {
        return $this->belongsToMany(Harvest::class, 'harvest_quarter');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
