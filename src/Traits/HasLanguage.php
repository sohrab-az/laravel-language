<?php

namespace SohrabAzinfar\Language\Traits;

use SohrabAzinfar\Language\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasLanguage
{
    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeLanguage(Builder $query, string|int|Language $language)
    {
        if ($language instanceof Language) 
            return $query->where('language_id', $language->id);
        
        if (is_int($language))
            return $query->where('language_id', $language);

        return $query->whereHas('language', function ($q) use ($language) {
            $q->where('code', $language);
        });
    }

    public function scopeDefaultLanguage(Builder $query)
    {
        return $query->whereHas('language', function ($q) {
            $q->where('is_default', true);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function setLanguage(string|Language $language): static
    {
        if ($language instanceof Language) {
            $this->language()->associate($language);
        } else {
            $model = Language::where('code', $language)->firstOrFail();
            $this->language()->associate($model);
        }

        return $this;
    }

    public function getLanguageCode(): ?string
    {
        return $this->language?->code;
    }

    public function isLanguage(string $code): bool
    {
        return $this->language?->code === $code;
    }
}