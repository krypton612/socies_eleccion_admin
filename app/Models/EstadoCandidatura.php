<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoCandidatura extends Model
{
    use HasFactory;

    protected $table = 'estado_candidatura';
    protected $primaryKey = 'id';

    protected $fillable = [
        'estado_candidatura',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con Candidatura
     */
    public function candidaturas(): HasMany
    {
        return $this->hasMany(Candidatura::class, 'estado_candidatura_id');
    }

    /**
     * Scope para estados activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado_candidatura', 'Activo');
    }

    /**
     * Scope para estados inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('estado_candidatura', 'Inactivo');
    }
}