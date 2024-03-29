<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Orderable;
use App\Traits\Searchable;
use App\Traits\Filterable;

use Carbon\Carbon;

class Dog extends Model
{
    use HasFactory, Orderable, Searchable, Filterable;

    protected $fillable = [
        'name',
        'breed',
        'gender',
        'birthdate',
        'veterinary',
        'quarter_id',
        'couple_id',
        'avatar',
    ];

    protected $searchableColumns = [
        'name',
        'breed',
        'veterinary',
    ];

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
