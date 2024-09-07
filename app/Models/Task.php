<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use Filterable, HasFactory, Orderable;

    protected $casts = [
        'rows' => 'array',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'task_tool');
    }

    public function machineries()
    {
        return $this->belongsToMany(Machinery::class, 'machineries_task');
    }

    public function supplies()
    {
        return $this->hasMany(SupplyTask::class);
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'comment_task');
    }

    public function quarters()
    {
        return $this->belongsToMany(Quarter::class);
    }

    public function plants()
    {
        return $this->belongsToMany(Plant::class);
    }
}
