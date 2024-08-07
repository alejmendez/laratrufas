<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Orderable;
use App\Traits\Filterable;

class Owner extends Model
{
    use HasFactory, Orderable, Filterable;

    protected $fillable = [
        'name',
        'dni',
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }
}
