<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Orderable;
use App\Traits\Searchable;
use App\Traits\Filterable;

class Plant extends Model
{
    use HasFactory, Orderable, Searchable, Filterable;

    protected $searchableColumns = [
    ];

    protected $fillable = [
        'plant_type_id',
        'age',
        'planned_at',
        'nursery_origin',
        'code',
        'blueprint',
        'quarter_id',
        'row',
    ];

    public function quarter(): BelongsTo
    {
        return $this->belongsTo(Quarter::class);
    }

    public function plant_type(): BelongsTo
    {
        return $this->belongsTo(PlantType::class);
    }
}
