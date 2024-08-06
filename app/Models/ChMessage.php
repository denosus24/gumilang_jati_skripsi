<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;
use Illuminate\Contracts\Database\Query\Builder;

class ChMessage extends Model
{
    use UUID;

    public function scopeUserUnread(Builder $query): void
    {
        if (auth()->user()) {
            $query->where('to_id', auth()->user()->id)
                ->where('seen', 0);
        }
    }
}
