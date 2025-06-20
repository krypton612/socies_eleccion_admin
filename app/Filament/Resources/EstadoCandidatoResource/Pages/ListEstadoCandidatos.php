<?php

namespace App\Filament\Resources\EstadoCandidatoResource\Pages;

use App\Filament\Resources\EstadoCandidatoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEstadoCandidatos extends ListRecords
{
    protected static string $resource = EstadoCandidatoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
