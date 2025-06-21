<?php

namespace App\Filament\Resources\CandidatoResource\Pages;

use App\Filament\Resources\CandidatoResource;
use App\Filament\Resources\CandidatoResource\Widgets\CandidatosOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCandidatos extends ListRecords
{
    protected static string $resource = CandidatoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array {
        return [
            CandidatosOverview::class,
        ];
    }
    
}
