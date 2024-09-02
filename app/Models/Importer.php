<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación con Batches (Uno a Muchos)
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
