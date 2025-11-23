<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('events', static function (Blueprint $table) {
            $table->id();

            $table->foreignUlid('event_type_id', 64)->constrained('event_types', 'identifier');
            $table->foreignId('assigned_user_id')->constrained('users');
            $table->foreignId('created_by_user_id')->constrained('users');

            $table->string('title');
            $table->text('description')->nullable();

            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
