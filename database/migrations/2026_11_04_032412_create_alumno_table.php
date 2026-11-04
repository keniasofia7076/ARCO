
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumno', function (Blueprint $table) {
            $table->id('id_alumno');

            $table->foreignId('id_persona')
                ->unique()
                ->constrained('persona', 'id_persona');

            $table->string('matricula', 30)->unique();

            $table->foreignId('id_division')
                ->constrained('division', 'id_division');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumno');
    }
};
