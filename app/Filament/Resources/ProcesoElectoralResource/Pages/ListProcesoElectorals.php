<?php

namespace App\Filament\Resources\ProcesoElectoralResource\Pages;

use App\Filament\Resources\ProcesoElectoralResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcesoElectorals extends ListRecords
{
    protected static string $resource = ProcesoElectoralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
