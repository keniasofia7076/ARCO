<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipo';

    protected $primaryKey = 'id_equipo';

    public $timestamps = false;

    protected $fillable = [
        'propietario',
        'id_marca',
        'numero_serie',
        'tipo_equipo',
        'modelo'
    ];

    // Relación con la persona propietaria
    public function persona()
    {
        return $this->belongsTo(
            Persona::class,
            'propietario',
            'matricula'
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

?>