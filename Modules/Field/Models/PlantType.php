<?php

namespace Modules\Field\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlantType extends Model
{
    use HasFactory;

    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class);
    }
}
