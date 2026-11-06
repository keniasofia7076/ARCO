
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipo', function (Blueprint $table) {
            $table->id('id_equipo');

            $table->foreignId('propietario')
                ->constrained('persona', 'matricula');

            $table->foreignId('id_marca')
                ->constrained('marca', 'id_marca');

            $table->string('numero_serie', 100)->unique();
            $table->string('tipo_equipo', 80);
            $table->string('modelo', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipo');
    }
};
