<?php

namespace App\Models\Admin\Menu;

use App\Models\Admin\Menu\Menu;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SubMenu extends Model
{
    use HasFactory;

    public static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->title);
        });

        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }


    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['created_at_format'];

    public function createdAtFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->format('d-m-Y')
        );
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }
}
