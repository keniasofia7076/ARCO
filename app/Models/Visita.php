<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table = 'visita';
    protected $primaryKey = 'id_visita';
    public $timestamps = false;

    protected $fillable = [
        'id_persona', 'id_edificio',
        'fecha_hora_entrada', 'fecha_hora_salida', 'motivo',
    ];

    protected $casts = [
        'fecha_hora_entrada' => 'datetime',
        'fecha_hora_salida'  => 'datetime',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'id_edificio', 'id_edificio');
    }
}