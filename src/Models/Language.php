<?php

namespace SohrabAzinfar\Language\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'code',
        'name',
        'direction',
        'is_active',
        'is_default',
        'meta'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'meta' => 'array'
    ];
}