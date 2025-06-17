<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    public $timestamps = true; // Desactiva timestamps automáticos ya que se manejan manualmente

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'cedula_identidad',
        'contrasena_hash',
        'correo',
        'estado',
        'fecha_nacimiento',
        'rol_id',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'contrasena_hash',
        'is_deleted'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'is_deleted' => 'boolean',
        'fecha_nacimiento' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'contrasena_hash' => 'hashed',
    ];

    protected $attributes = [
        'estado' => true,
    ];

    /**
     * Relación con Rol
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    /**
     * Relación con Votos emitidos
     */
    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class, 'usuario_id');
    }

    /**
     * Accesor para nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}");
    }

    /**
     * Accesor para edad
     */
    public function getEdadAttribute(): int
    {
        return $this->fecha_nacimiento->age;
    }

    /**
     * Filament: Nombre para mostrar en el panel
     */
    public function getFilamentName(): string
    {
        return $this->nombre_completo;
    }

    /**
     * Filament: Verificar acceso al panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->estado && !$this->is_deleted;
    }

    /**
     * Obtener contraseña para autenticación
     */
    public function getAuthPassword(): string
    {
        $password_db = $this->contrasena_hash;
        if (str_starts_with($password_db, '$2a$')) {
            $password_db = '$2y$' . substr($password_db, 4);
        }

        return $password_db;
    }

    /**
     * Scope para usuarios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', true)->where('is_deleted', false);
    }

    /**
     * Scope para buscar por cédula de identidad
     */
    public function scopePorCedula($query, $cedula)
    {
        return $query->where('cedula_identidad', $cedula);
    }

    /**
     * Scope para buscar por correo
     */
    public function scopePorCorreo($query, $correo)
    {
        return $query->where('correo', $correo);
    }

    public function username(): string
    {
        return 'correo';
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getEmailAttribute()
    {
        return $this->correo;
    }
   
}