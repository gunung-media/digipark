<?php

namespace App\Models;

use Filament\Forms\Components\Concerns\HasMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class NewsCategory extends Model
{
    use HasFactory;

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
