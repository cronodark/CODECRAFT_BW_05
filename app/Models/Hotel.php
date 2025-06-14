<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasVersion4Uuids;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Hotel extends Model
{
    use HasVersion4Uuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'location',
        'owner_id',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Uuid::uuid4();
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }


}
