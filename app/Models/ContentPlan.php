<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentPlan extends Model
{
    use HasFactory;

    public function content_plan_revisions()
    {
        return $this->hasMany(ContentPlanRevision::class);
    }
}
