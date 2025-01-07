<?php

namespace Modules\Field\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importer extends Model
{
    use HasFactory;

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
