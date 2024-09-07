<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

use App\Traits\Orderable;
use App\Traits\Filterable;

class Harvest extends Model
{
    use HasFactory, Orderable, Filterable;

    protected static function booted()
    {
        static::saving(function ($harvest) {
            $harvest->year = Carbon::parse($harvest->date)->year;
        });
    }

    public function details(): HasMany
    {
        return $this->hasMany(HarvestDetail::class);
    }

    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::class);
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function assistant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assistant_id');
    }

    public function quarters()
    {
        return $this->belongsToMany(Quarter::class, 'harvest_quarter');
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_harvest');
    }
}
