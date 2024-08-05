<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Orderable;
use App\Traits\Filterable;

class Harvest extends Model
{
    use HasFactory, Orderable, Filterable;

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
        return $this->belongsToMany(Quarter::class);
    }
}
