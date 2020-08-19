<?php

namespace App;

use App\Events\PaymentResolved;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Payment extends Model
{
    use Notifiable;

    protected $fillable = ['value', 'recipient', 'resolved_at', 'notificationURL'];

    protected $dates = [
        'created_at',
        'resolved_at',
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->created_at = Carbon::now();
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
        return $query->when($request->has('from'), function ($query) use ($request) {
            $query
                ->where(
                    'resolved_at',
                    '>=',
                    Carbon::parse($request->from)
                );
        });
    }

    public function scopeTo(Builder $query, Request $request)
    {
        return $query->when($request->has('to'), function ($query) use ($request) {
            $query
                ->where(
                    'resolved_at',
                    '<=',
                    Carbon::parse($request->to)
                );
        });
    }

    public function resolve()
    {
        $this->update(['resolved_at' => Carbon::now()]);
        if (! empty($this->notificationURL)) {
            event(new PaymentResolved($this));
        }
    }

}
