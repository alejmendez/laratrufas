<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use Filterable, HasFactory, Orderable;

    protected $fillable = [
        'name',
        'dni',
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }
}
