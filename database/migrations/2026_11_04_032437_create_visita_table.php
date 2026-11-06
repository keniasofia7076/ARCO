
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

    $table->string('nombre', 100);
    $table->string('apellido_paterno', 100);
    $table->string('apellido_materno', 100)->nullable();
    $table->string('correo', 150)->nullable();

    $table->foreignId('id_edificio')
        ->constrained('edificio', 'id_edificio')
        ->restrictOnDelete();

    $table->timestampTz('fecha_hora_entrada')->useCurrent();
    $table->timestampTz('fecha_hora_salida')->nullable();

    $table->string('motivo', 250);
});
    }

    public function down(): void
    {
        Schema::dropIfExists('visita');
    }
};
