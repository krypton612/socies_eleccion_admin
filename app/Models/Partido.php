<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partido extends Model
{
    use HasFactory;

    protected $table = 'partido';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_partido',
        'sigla',
        'lema',
        'descripcion',
        'fecha_fundacion',
        'representante_legal',
        'direccion_sede',
        'pais',
        'telefono_contacto',
        'correo_contacto',
        'pagina_web',
        'logo_url',
        'color_hex',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'fecha_fundacion' => 'datetime',
        'estado' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con Candidatura
     */
    public function candidaturas(): HasMany
    {
        return $this->hasMany(Candidatura::class, 'partido_id');
    }

    /**
     * Scope para partidos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    /**
     * Scope para partidos inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('estado', false);
    }

    /**
     * Accesor para información básica del partido
     */
    public function getInfoBasicaAttribute(): string
    {
        return "{$this->sigla} - {$this->nombre_partido}";
    }

    /**
     * Accesor para años desde fundación
     */
    public function getAniosFundacionAttribute(): ?int
    {
        return $this->fecha_fundacion?->diffInYears(now());
    }
}