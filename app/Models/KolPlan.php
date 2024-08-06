<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KolPlan extends Model
{
    use HasFactory;

    protected function cpm(): Attribute
    {
        return Attribute::make(
            get: fn () => floor($this->views / 1000) < 1 ? 0 : $this->cost / floor($this->views / 1000),
        );
    }

    public function order_report(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
