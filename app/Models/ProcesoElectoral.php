<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcesoElectoral extends Model
{
    use HasFactory;

    protected $table = 'proceso_electoral';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_proceso',
        'descripcion_proceso',
        'fecha_inicio',
        'fecha_fin',
        'estado_proceso_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con EstadoProceso
     */
    public function estadoProceso(): BelongsTo
    {
        return $this->belongsTo(EstadoProceso::class, 'estado_proceso_id');
    }

    /**
     * Relación con Candidatura
     */
    public function candidaturas(): HasMany
    {
        return $this->hasMany(Candidatura::class, 'proceso_electoral_id');
    }

    /**
     * Relación con Voto
     */
    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class, 'proceso_id');
    }

    /**
     * Accesor para verificar si el proceso está activo
     */
    public function getEstaActivoAttribute(): bool
    {
        $now = now();
        return $now->between($this->fecha_inicio, $this->fecha_fin);
    }

    /**
     * Accesor para obtener la duración en días
     */
    public function getDuracionDiasAttribute(): int
    {
        return $this->fecha_inicio->diffInDays($this->fecha_fin);
    }
}