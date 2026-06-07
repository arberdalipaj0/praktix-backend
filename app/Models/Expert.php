<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expert extends Model
{
    protected $fillable = [
        'name',
        'title',
        'specialization',
        'experience',
        'bio',
        'profile_image',
    ];

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
