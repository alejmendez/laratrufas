<?php

namespace Modules\Tasks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCorrelative extends Model
{
    use HasFactory;

    protected $fillable = ['correlative', 'year'];
}
