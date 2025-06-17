<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoCandidato extends Model
{
    protected $table = 'estado_candidato';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'estado_candidato',
        'created_at',
        'updated_at'
    ];

    public function candidatos(): HasMany
    {
        return $this->hasMany(Candidato::class);
    }    
}
