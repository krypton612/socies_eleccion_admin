<?php

namespace App\Filament\Resources\VotoResource\Pages;

use App\Filament\Resources\VotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVotos extends ListRecords
{
    protected static string $resource = VotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
