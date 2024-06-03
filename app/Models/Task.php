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

class Task extends Model
{
    use HasFactory, Orderable, Searchable, Filterable;

    protected $fillable = [
        'name',
        'repeat_number',
        'repeat_type',
        'status',
        'priority',
        'start_date',
        'end_date',
        'field_id',
        'quarter_id',
        'plant_id',
        'responsible_id',
        'note',
        'comments',
    ];
}
