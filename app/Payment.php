<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = ['value', 'recipient'];

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

    public function setUpdatedAt($value) {}
}
