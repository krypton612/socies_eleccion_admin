<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoProceso extends Model
{
    use HasFactory;

    protected $table = 'estado_proceso';
    protected $primaryKey = 'id';

    protected $fillable = [
        'estado_proceso',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con ProcesoElectoral
     */
    public function procesosElectorales(): HasMany
    {
        return $this->hasMany(ProcesoElectoral::class, 'estado_proceso_id');
    }
}