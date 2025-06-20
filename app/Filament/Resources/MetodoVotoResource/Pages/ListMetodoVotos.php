<?php

namespace App\Filament\Resources\MetodoVotoResource\Pages;

use App\Filament\Resources\MetodoVotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMetodoVotos extends ListRecords
{
    protected static string $resource = MetodoVotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
