<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use KodePandai\Indonesia\Models\Village;

class InfoEmployment extends Model
{
    use HasFactory;

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'village_code');
    }
}
