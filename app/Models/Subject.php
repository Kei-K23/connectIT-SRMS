<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'course_id',
        'start_time',
        'end_time',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }


    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        $query->orderBy('created_at', 'desc');
    }
}
