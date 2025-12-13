<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('changelog', static function (Blueprint $table) {
            $table->id();
            $table->string('action', 25);
            $table->integer('id_row');
            $table->string('table_name', 25);
            $table->string('column_name', 25)->nullable();
            $table->string('old_value', 255)->nullable();
            $table->string('new_value', 255)->nullable();
            $table->integer('id_changed_by');
            $table->timestamp('changed_at');
            $table->integer('change_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('changelog');
    }
};
