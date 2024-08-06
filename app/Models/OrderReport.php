<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderReport extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function content_plans(): HasMany
    {
        return $this->hasMany(ContentPlan::class);
    }

    public function kol_plans(): HasMany
    {
        return $this->hasMany(KolPlan::class);
    }
}
