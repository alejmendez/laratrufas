<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Orderable;
use App\Traits\Filterable;

use Carbon\Carbon;

class Dog extends Model
{
    use HasFactory, Orderable, Filterable;

    public function quarter(): BelongsTo
    {
        return $this->belongsTo(Quarter::class);
    }

    public function vaccines(): HasMany
    {
        return $this->hasMany(DogVaccine::class);
    }

    public function couple(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }
}
