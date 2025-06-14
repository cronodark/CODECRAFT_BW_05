<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasVersion4Uuids;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Room extends Model
{
    use HasVersion4Uuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'hotel_id',
        'name',
        'price',
        'description',
        'capacity',
    ];

    public static function booted(){
        static::creating(function($model){
            $model->id = Uuid::uuid4();
        });
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
