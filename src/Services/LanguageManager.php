<?php

namespace SohrabAzinfar\Language\Services;

use SohrabAzinfar\Language\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LanguageManager
{
    public function all(): Collection
    {
        return Language::query()->get();
    }

    public function active(): Collection
    {
        return Language::query()
            ->where('is_active', true)
            ->get();
    }

    public function default(): ?Language
    {
        return Language::query()
            ->where('is_default', true)
            ->first();
    }

    public function find(string $code): ?Language
    {
        return Language::query()
            ->where('code', $code)
            ->first();
    }

    public function exists(string $code): bool
    {
        return Language::query()
            ->where('code', $code)
            ->exists();
    }

    public function setDefault(string $code): void
    {
        DB::transaction(function () use ($code) {

            Language::query()->update([
                'is_default' => false
            ]);

            Language::query()
                ->where('code', $code)
                ->update([
                    'is_default' => true
                ]);
        });
    }

    public function activate(string $code): void
    {
        Language::where('code', $code)
            ->update(['is_active' => true]);
    }

    public function deactivate(string $code): void
    {
        Language::where('code', $code)
            ->update(['is_active' => false]);
    }
}