<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Orderable;
use App\Traits\Filterable;

class PlantType extends Model
{
    use HasFactory, Orderable, Filterable;

    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class);
    }
}
