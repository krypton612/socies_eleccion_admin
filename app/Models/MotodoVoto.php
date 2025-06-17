<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetodoVoto extends Model
{
    use HasFactory;

    protected $table = 'metodo_voto';
    protected $primaryKey = 'id';
    public $timestamps = false; // Desactiva timestamps automáticos ya que se manejan manualmente

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
     * Relación con Voto
     */
    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class, 'metodo_voto_id');
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
    public function getNombreFormateadoAttribute(): string
    {
        return mb_strtoupper($this->nombre);
    }

    /**
     * Obtener estadísticas de uso del método
     */
    public function getEstadisticasUsoAttribute(): array
    {
        return [
            'total_votos' => $this->votos()->count(),
            'ultimo_mes' => $this->votos()
                ->where('created_at', '>=', now()->subMonth())
                ->count()
        ];
    }
}