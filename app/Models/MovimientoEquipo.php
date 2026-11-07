<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoEquipo extends Model
{
    protected $table = 'movimiento_equipo';

    protected $primaryKey = 'id_movimiento';

    public $timestamps = false;

    protected $fillable = [
        'id_equipo',
        'fecha_hora_entrada',
        'fecha_hora_salida',
    ];

    protected $casts = [
        'fecha_hora_entrada' => 'datetime',
        'fecha_hora_salida' => 'datetime',
    ];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(
            Equipo::class,
            'id_equipo',
            'id_equipo'
        );
    }
}