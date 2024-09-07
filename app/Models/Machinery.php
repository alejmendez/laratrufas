<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machinery extends Model
{
    use Filterable, HasFactory, Orderable;
}
