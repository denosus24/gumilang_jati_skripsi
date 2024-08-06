<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'images'            => 'array',
            'people_in_needs'   => 'array',
            'advantages'        => 'array',
            'faqs'              => 'array',
        ];
    }

    public function service_category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    protected function imageWithUrls(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value) {
                $images = $this->images;
                $imagesWithUrl = [];

                foreach ($images as $image) {
                    $imagesWithUrl[] = asset('storage/' . $image);
                }

                return $imagesWithUrl;
            }
        );
    }
}
