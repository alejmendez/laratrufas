<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number',
        'delivery_date',
        'importer_id',
    ];

    // Relación con Importer (Muchos a Uno)
    public function importer()
    {
        return $this->belongsTo(Importer::class);
    }

    // Relación con Harvests (Muchos a Muchos)
    public function harvests()
    {
        return $this->belongsToMany(Harvest::class, 'batch_harvest');
    }
}
