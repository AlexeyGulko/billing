<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = ['value', 'recipient', 'resolved_at'];

    protected $dates = [
        'resolved_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->uuid = Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getExpiresAtAttribute($value)
    {
        return $this->created_at->addMinutes(2);
    }

    public function isExpired()
    {
        return $this->expires_at <= Carbon::now();
    }
}
