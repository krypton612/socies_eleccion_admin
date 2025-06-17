<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voto extends Model
{
    use HasFactory;

    protected $table = 'voto';
    protected $primaryKey = 'id';
    public $timestamps = false; // Desactiva timestamps automáticos ya que se manejan manualmente

    protected $fillable = [
        'hash_votacion',
        'candidatura_id',
        'metodo_voto_id',
        'proceso_id',
        'ubicacion_voto_id',
        'usuario_id',
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
    public function candidatura(): BelongsTo
    {
        return $this->belongsTo(Candidatura::class, 'candidatura_id');
    }

    /**
     * Relación con MétodoVoto
     */
    public function metodoVoto(): BelongsTo
    {
        return $this->belongsTo(MetodoVoto::class, 'metodo_voto_id');
    }

    /**
     * Relación con ProcesoElectoral
     */
    public function procesoElectoral(): BelongsTo
    {
        return $this->belongsTo(ProcesoElectoral::class, 'proceso_id');
    }

    /**
     * Relación con UbicacionVoto
     */
    public function ubicacionVoto(): BelongsTo
    {
        return $this->belongsTo(UbicacionVoto::class, 'ubicacion_voto_id');
    }

    /**
     * Relación con Usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Scope para votos en un proceso electoral específico
     */
    public function scopePorProceso($query, $procesoId)
    {
        return $query->where('proceso_id', $procesoId);
    }

    /**
     * Scope para votos de un usuario específico
     */
    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    /**
     * Verificar si el voto es válido (hash no nulo)
     */
    public function getEsValidoAttribute(): bool
    {
        return !empty($this->hash_votacion);
    }

    /**
     * Obtener información resumida del voto
     */
    public function getInfoResumidaAttribute(): string
    {
        return "Voto #{$this->id} - Proceso: {$this->procesoElectoral->nombre_proceso}";
    }
}