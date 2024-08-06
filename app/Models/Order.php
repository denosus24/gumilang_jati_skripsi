<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected function kolRealCost(): Attribute
    {
        $setting = Setting::first();

        return Attribute::make(
            get: fn () => $this->amount - ($this->amount * $setting->kol_fee_percentage / 100),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function order_report(): HasOne
    {
        return $this->hasOne(OrderReport::class);
    }

    public function order_reports(): HasMany
    {
        return $this->hasMany(OrderReport::class);
    }

    public function content_plans(): HasManyThrough
    {
        return $this->hasManyThrough(ContentPlan::class, OrderReport::class);
    }

    public function kol_plans(): HasManyThrough
    {
        return $this->hasManyThrough(KolPlan::class, OrderReport::class);
    }
}
