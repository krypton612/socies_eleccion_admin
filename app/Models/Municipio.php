<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipio';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'provincia_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con Provincia (padre)
     */
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

    /**
     * Relación con UbicacionVoto
     */
    public function ubicacionesVoto(): HasMany
    {
        return $this->hasMany(UbicacionVoto::class, 'municipio_id');
    }

    /**
     * Scope para búsqueda por nombre
     */
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }

    /**
     * Scope para municipios de una provincia específica
     */
    public function scopePorProvincia($query, $provinciaId)
    {
        return $query->where('provincia_id', $provinciaId);
    }

    /**
     * Accesor para jerarquía completa (Municipio - Provincia - Departamento)
     */
    public function getJerarquiaCompletaAttribute(): string
    {
        return "{$this->nombre}, {$this->provincia->nombre}, {$this->provincia->departamento->nombre}";
    }

    /**
     * Accesor para nombre con provincia
     */
    public function getNombreConProvinciaAttribute(): string
    {
        return "{$this->nombre} ({$this->provincia->nombre})";
    }
}