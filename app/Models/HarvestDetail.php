<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HarvestDetail extends Model
{
    protected $fillable = [
        'harvest_id',
        'plant_id',
        'number',
        'quality',
        'weight',
    ];

    public function harvest(): BelongsTo
    {
        return $this->belongsTo(Harvest::class);
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
