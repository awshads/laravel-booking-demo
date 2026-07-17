<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $facility_id
 * @property Carbon $booked_at
 * @property int $booked_by_id
 * @property string $status
 * @property Carbon|null $reviewed_at
 * @property int|null $reviewed_by_id
 * @property Carbon|null $completed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['facility_id', 'booked_at', 'booked_by_id', 'status', 'reviewed_at', 'reviewed_by_id', 'completed_at'])]
class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'booked_by_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('facility.name', 'like', '%'.$search.'%')
                    ->orWhere('user.name', 'like', '%'.$search.'%');
            });
        })->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed) {
                $query->onlyTrashed();
            }
        })->when($filters['user_id'] ?? null, function ($query, $userId) {
            $query->where('booked_by_id', $userId);
        })->when($filters['facility_id'] ?? null, function ($query, $facilityId) {
            $query->where('facility_id', $facilityId);
        })->when($filters['reviewed_by_id'] ?? null, function ($query, $reviewerId) {
            $query->where('reviewed_by_id', $reviewerId);
        });
    }


}
