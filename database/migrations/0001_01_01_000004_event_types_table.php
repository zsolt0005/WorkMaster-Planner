<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('event_types', static function (Blueprint $table) {
            $table->string('identifier', 64)->primary();
            $table->string('description')->nullable();
            $table->string('background_color');
            $table->string('text_color');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_types');
    }
};
