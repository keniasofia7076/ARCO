
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal', function (Blueprint $table) {
    $table->id('matricula');

    $table->string('nombre', 100);
    $table->string('apellido_paterno', 100);
    $table->string('apellido_materno', 100)->nullable();

    $table->unsignedTinyInteger('tipo_personal')->default(1);

    $table->foreignId('id_edificio')
        ->nullable()
        ->constrained('edificio', 'id_edificio')
        ->nullOnDelete();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
