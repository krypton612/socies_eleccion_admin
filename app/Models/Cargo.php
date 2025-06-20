<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends Model
{
    protected $table = 'cargo';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'created_at',
        'updated_at'
    ];

    public function candidatos(): HasMany
    {
        return $this->hasMany(Candidato::class);
    }    
}
