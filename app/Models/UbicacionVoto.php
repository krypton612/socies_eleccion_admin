<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UbicacionVoto extends Model
{
    use HasFactory;

    protected $table = 'ubicacion_voto';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_ubicacion',
        'descripcion_ubicacion',
        'direccion',
        'latitude',
        'longitude',
        'municipio_id',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'estado' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con Municipio
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    /**
     * Relación con Voto
     */
    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class, 'ubicacion_voto_id');
    }

    public function getTotalVotosAttribute(): int
    {
        return $this->votos()->count() ?? 0;
    }

    /**
     * Scope para ubicaciones activas
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', true);
    }

    /**
     * Scope para búsqueda por nombre
     */
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre_ubicacion', 'like', "%{$nombre}%");
    }

    /**
     * Accesor para coordenadas completas
     */
    public function getCoordenadasAttribute(): string
    {
        return "{$this->latitude}, {$this->longitude}";
    }

    /**
     * Accesor para ubicación completa
     */
    public function getUbicacionCompletaAttribute(): string
    {
        return "{$this->nombre_ubicacion}, {$this->municipio->nombre}, {$this->municipio->provincia->nombre}";
    }
}