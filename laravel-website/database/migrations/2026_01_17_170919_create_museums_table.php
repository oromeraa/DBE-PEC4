<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('museums', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('ciudad');
            // temática es la tabla pivot que relaciona modelos
            $table->text('fechas_horarios');
            $table->enum('visitas_guiadas', ['si', 'no']);
            $table->decimal('precio', 8, 2);
            $table->string('imagen_portada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('museums');
    }
};
