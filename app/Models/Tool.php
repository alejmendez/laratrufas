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

class Tool extends Model
{
    use HasFactory, Orderable, Filterable;

    protected $fillable = [
        'name',
        'purchase_date',
        'last_maintenance',
        'purchase_location',
        'type',
        'contact',
    ];
}
