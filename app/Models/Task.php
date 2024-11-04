<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

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

    public function security_equipments()
    {
        return $this->belongsToMany(SecurityEquipment::class, 'security_equipment_task');
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
