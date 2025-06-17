<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamento';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con Provincia
     */
    public function provincias(): HasMany
    {
        return $this->hasMany(Provincia::class, 'departamento_id');
    }

    /**
     * Scope para búsqueda por nombre
     */
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }

    /**
     * Accesor para nombre en mayúsculas
     */
    public function getNombreMayusculasAttribute(): string
    {
        return mb_strtoupper($this->nombre);
    }
}