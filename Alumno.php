<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumno';

    protected $primaryKey = 'id_alumno';

    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id_alumno', 'id_alumno');
    }
}