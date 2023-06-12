<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
            'user_id',
            'vehicle_make',
            'vehicle_model',
            'booking_date',
            'booking_time',
        ];

//    create a random uuid for the id
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) \Illuminate\Support\Str::uuid();
        });
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
