<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidato extends Model
{
    use HasFactory;

    protected $table = 'candidato';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_candidato',
        'apellido_paterno',
        'apellido_materno',
        'cedula_identidad',
        'correo',
        'fecha_nacimiento',
        'foto_url',
        'propuesta',
        'cargo_id',
        'estado_candidato_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con el modelo Cargo
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    /**
     * Relación con el modelo EstadoCandidato
     */
    public function estadoCandidato(): BelongsTo
    {
        return $this->belongsTo(EstadoCandidato::class);
    }

    /**
     * Relación con el modelo Candidatura
     */
    public function candidaturas(): HasMany
    {
        return $this->hasMany(Candidatura::class);
    }

    /**
     * Accesor para nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre_candidato} {$this->apellido_paterno} {$this->apellido_materno}");
    }

    /**
     * Accesor para edad
     */
    public function getEdadAttribute(): int
    {
        return $this->fecha_nacimiento->age;
    }
}