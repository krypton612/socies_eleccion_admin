<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'tipo_rol',
        'created_at',
        'updated_at'
    ];

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class);
    }    
}
