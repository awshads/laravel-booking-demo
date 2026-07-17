<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property int $capacity
 * @property string $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['name', 'description', 'type', 'capacity', 'location'])]
class Facility extends Model
{
    /** @use HasFactory<FacilityFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
        ];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'facility_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%');
            });
        })->when($filters['type'] ?? null, function ($query, $type) {
            $query->where('type', $type);
        })->when($filters['capacity'] ?? null, function ($query, $capacity) {
            $query->where('capacity', '>=', $capacity);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed) {
                $query->onlyTrashed();
            }
        });
    }
}
