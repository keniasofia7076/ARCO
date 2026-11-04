
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimiento_equipo', function (Blueprint $table) {
            $table->id('id_movimiento');

            $table->foreignId('id_equipo')
                ->constrained('equipo', 'id_equipo');

            $table->timestampTz('fecha_hora_entrada')
                ->useCurrent();

            $table->timestampTz('fecha_hora_salida')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimiento_equipo');
    }
};
