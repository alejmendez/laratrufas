<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Quarter;
use App\Models\PlantType;
use App\Models\HarvestDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plant extends Model
{
    use HasFactory;

    public function quarter(): BelongsTo
    {
        return $this->belongsTo(Quarter::class);
    }

    public function plant_type(): BelongsTo
    {
        return $this->belongsTo(PlantType::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function harvest_details(): HasMany
    {
        return $this->hasMany(HarvestDetail::class);
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper(trim($value)),
            set: fn (string $value) => strtoupper(trim($value)),
        );
    }

    public function age(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->calculateAgeWithDecimals($this->planned_at),
        );
    }

    protected function calculateAgeWithDecimals($birthDate)
    {
        $birthDate = Carbon::parse($birthDate);
        $currentDate = Carbon::now();

        $yearsDifference = abs($currentDate->diffInYears($birthDate));
        $monthsDifference = abs($currentDate->diffInMonths($birthDate) % 12);
        $daysDifference = abs($currentDate->diffInDays($birthDate->copy()->addYears($yearsDifference)->addMonths($monthsDifference)));

        $age = $yearsDifference + ($monthsDifference / 12) + ($daysDifference / 365.25);

        return round($age, 2);
    }
}
