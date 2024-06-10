<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'quantity', 'unit', 'task_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
