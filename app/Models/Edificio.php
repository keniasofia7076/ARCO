<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    protected $table = 'edificio';
    protected $primaryKey = 'id_edificio';
    public $timestamps = false;

    protected $fillable = ['nombre'];
}