
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visita', function (Blueprint $table) {
            $table->id('id_visita');

            $table->foreignId('id_persona')
                ->constrained('persona', 'id_persona');

            $table->timestampTz('fecha_hora_entrada')
                ->useCurrent();

            $table->timestampTz('fecha_hora_salida')
                ->nullable();

            $table->string('motivo', 250);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visita');
    }
};
