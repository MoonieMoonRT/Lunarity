<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceNumber extends Model
{
    protected $fillable = [
        'extension', 'department', 'description',
        'is_easter_egg', 'easter_egg_url',
    ];

    protected function casts(): array
    {
        return [
            'is_easter_egg' => 'boolean',
        ];
    }
}
