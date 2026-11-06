<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipo';

    protected $primaryKey = 'id_equipo';

    public $timestamps = false;

    protected $fillable = [
        'id_alumno',
        'id_marca',
        'numero_serie',
        'tipo_equipo',
        'modelo'
    ];

    // Relación con alumno
    public function alumno()
    {
        return $this->belongsTo(
            Alumno::class,
            'id_alumno',
            'id_alumno'
        );
    }

    // Relación con marca
    public function marca()
    {
        return $this->belongsTo(
            Marca::class,
            'id_marca',
            'id_marca'
        );
    }

    // Relación con movimientos
    public function movimientos()
    {
        return $this->hasMany(
            MovimientoEquipo::class,
            'id_equipo',
            'id_equipo'
        );
    }
}