<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    protected $fillable = [
        'title',
        'category',
        'description',
        'duration',
        'price',
        'image_url',
        'expert_id',
        'certificate_included',
    ];

    protected function casts(): array
    {
        return [
            'certificate_included' => 'boolean',
            'price' => 'float',
        ];
    }

    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}