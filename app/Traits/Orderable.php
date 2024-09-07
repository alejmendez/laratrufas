<?php

namespace App\Traits;

use App\Utils\Query;
use Illuminate\Database\Eloquent\Builder;

trait Orderable
{
    public function scopeOrder(Builder $query, string $order = ''): void
    {
        Query::order($query, $order);
    }
}
