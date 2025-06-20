<?php

namespace App\Filament\Resources\EstadoCandidaturaResource\Pages;

use App\Filament\Resources\EstadoCandidaturaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEstadoCandidaturas extends ListRecords
{
    protected static string $resource = EstadoCandidaturaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
