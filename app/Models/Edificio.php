<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    protected $table = 'edificio';

    protected $primaryKey = 'id_edificio';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'division',
    ];

    // Personas relacionadas con el edificio.
    public function personas()
    {
        return $this->hasMany(Persona::class, 'id_edificio', 'id_edificio');
    }

    // Visitas relacionadas con el edificio.
    public function visitas()
    {
        return $this->hasMany(Visita::class, 'id_edificio', 'id_edificio');
    }
}
