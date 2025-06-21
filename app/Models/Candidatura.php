<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidatura extends Model
{
    use HasFactory;

    protected $table = 'candidatura';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_candidatura',
        'lema',
        'candidato_id',
        'estado_candidatura_id',
        'partido_id',
        'proceso_electoral_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con Candidato
     */
    public function candidato(): BelongsTo
    {
        return $this->belongsTo(Candidato::class, 'candidato_id');
    }

    /**
     * Relación con EstadoCandidatura
     */
    public function estadoCandidatura(): BelongsTo
    {
        return $this->belongsTo(EstadoCandidatura::class, 'estado_candidatura_id');
    }

    /**
     * Relación con Partido
     */
    public function partido(): BelongsTo
    {
        return $this->belongsTo(Partido::class, 'partido_id');
    }

    /**
     * Relación con ProcesoElectoral
     */
    public function procesoElectoral(): BelongsTo
    {
        return $this->belongsTo(ProcesoElectoral::class, 'proceso_electoral_id');
    }

    /**
     * Relación con Voto
     */
    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class, 'candidatura_id');
    }

    /**
     * Accesor para el nombre completo de la candidatura
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre_candidatura} - {$this->candidato->nombre_completo}";
    }

    /**
     * Scope para candidaturas activas
     */
    public function scopeActivas($query)
    {
        return $query->whereHas('estadoCandidatura', function($q) {
            $q->where('estado_candidatura', 'Activo');
        });
    }

    public function getTotalVotosAttribute(): int
    {
        return $this->votos()->count();
    }
}