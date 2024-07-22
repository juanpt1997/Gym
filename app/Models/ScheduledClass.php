<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScheduledClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'class_type_id',
        'date_time',
    ];

    protected function casts(): array
    {
        return
            ['date_time' => 'datetime'];
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function classType()
    {
        return $this->belongsTo(ClassType::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'bookings');
    }

    public function scopeUpcoming(Builder $query)
    {
        return $query->where('date_time', '>', now());
    }

    public static function scopeNotBooked(Builder $query)
    {
        return $query->whereDoesntHave('members', function (Builder $query) {
            $query->where('user_id', auth()->user()->id);
        }); /* this way we are not showing a class that was already booked by the same member */
    }
}
