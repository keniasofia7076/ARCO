<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';

    protected $primaryKey = 'matricula';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'matricula',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'tipo_personal',
        'id_edificio',
        'password',
        'activo',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }
    public function equipos()
    {
        return $this->hasMany(
            Equipo::class,
            'propietario',
            'matricula'
        );
    }

    // Relación con edificio
    public function edificio()
    {
        return $this->belongsTo(
            Edificio::class,
            'id_edificio',
            'id_edificio'
        );
    }
}
