<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoEquipo extends Model
{
    protected $table = 'movimiento_equipo';

    protected $primaryKey = 'id_movimiento';

    public $timestamps = false;

    public function equipo()
    {
        return $this->belongsTo(
            Equipo::class,
            'id_equipo',
            'id_equipo'
        );
    }
}