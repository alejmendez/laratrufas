<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Utils\Query;

trait Orderable
{

    public function scopeOrder(Builder $query, String $order = ''): void
    {
        Query::order($query, $order);
    }
}
