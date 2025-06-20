<?php

namespace App\Filament\Resources\CandidatoResource\Pages;

use App\Filament\Resources\CandidatoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCandidato extends EditRecord
{
    protected static string $resource = CandidatoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
