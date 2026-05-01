<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name');

            $table->enum('direction', ['ltr', 'rtl'])->default('ltr');

            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);

            $table->json('meta')->nullable();

            $table->timestamps();
        });

        foreach(config('language.supported') as $language) {
            DB::table('languages')->insert([
                'code' => $language['code'],
                'name' => $language['name'],
                'is_default' => config('language.default') == $language['code'] ? true : false,
                'is_active' => $language['active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
