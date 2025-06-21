<?php

namespace App\Filament\Resources\CandidaturaResource\Pages;

use App\Filament\Resources\CandidaturaResource;
use App\Filament\Resources\CandidaturaResource\Widgets\CandidaturaOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCandidaturas extends ListRecords
{
    protected static string $resource = CandidaturaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array {
        return [
            CandidaturaOverview::class,
        ];
    }
}
