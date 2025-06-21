<?php

namespace App\Filament\Resources\CandidatoResource\Widgets;

use App\Models\Candidato;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CandidatosOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $candidatos = Candidato::all();
        $totalCandidatos = $candidatos->count();
        $totalCandidatosConCargo = $candidatos->where('cargo_id', '=', "Sin Cargo")->count();
        $totalCandidatosSinCargo = $candidatos->where('cargo_id', '!=', "Sin Cargo")->count();


        return [
            Stat::make('Total de candidatos', $totalCandidatos)
                ->description("Todos los candidatos del sistema")
                ->descriptionIcon('heroicon-o-arrow-up')
                ->icon('heroicon-o-user-group')
                ->color('success'), 
            Stat::make('Candidatos con cargo.', $totalCandidatosConCargo)
                ->description("Candidatos con cargo en institución")
                ->icon('heroicon-o-user-group')
                ->color('warning'), 

            Stat::make('Candidatos sin cargo', $totalCandidatosSinCargo)
                ->description("Candidatos sin cargo en institución")
                ->icon('heroicon-o-user-group')
                ->color('warning'), 
        ];
    }
}
