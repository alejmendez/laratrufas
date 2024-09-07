<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Orderable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dog extends Model
{
    use Filterable, HasFactory, Orderable;

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
