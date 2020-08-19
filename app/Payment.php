<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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
        return $this->created_at->addMinutes(30);
    }

    public function isExpired()
    {
        return $this->expires_at <= Carbon::now();
    }

    public function scopeResolved(Builder $query)
    {
        return $query->where('resolved_at', '!=', null);
    }

    public function scopeFrom(Builder $query, Request $request)
    {
        if ($request->has('from')) {
            return $query
                ->where(
                    'resolved_at',
                    '>=',
                    Carbon::parse($request->from)
                );
        }
        return $query;
    }

    public function scopeTo(Builder $query, Request $request)
    {
        if ($request->has('to')) {
            return $query
                ->where(
                    'resolved_at',
                    '<=',
                    Carbon::parse($request->to)
                );
        }
        return $query;
    }
}
