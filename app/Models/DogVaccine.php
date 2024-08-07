<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class DogVaccine extends Model
{
    use HasFactory;

    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::class);
    }
}
