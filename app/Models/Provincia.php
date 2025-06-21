<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provincia extends Model
{
    use HasFactory;

    protected $table = 'provincia';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'departamento_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con Departamento (padre)
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Relación con Municipio (hijos)
     */
    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class, 'provincia_id');
    }

    /**
     * Scope para búsqueda por nombre
     */
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }

    /**
     * Scope para provincias de un departamento específico
     */
    public function scopePorDepartamento($query, $departamentoId)
    {
        return $query->where('departamento_id', $departamentoId);
    }

    /**
     * Accesor para nombre completo (incluye departamento)
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre}, {$this->departamento->nombre}";
    }
}