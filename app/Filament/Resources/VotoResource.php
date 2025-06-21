<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VotoResource\Pages;
use App\Filament\Resources\VotoResource\RelationManagers;
use App\Filament\Resources\VotoResource\Widgets\VotoOverview;
use App\Models\Voto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VotoResource extends Resource
{
    protected static ?string $model = Voto::class;

    protected static ?string $navigationLabel = 'Votos Finalizados';

    protected static ?string $pluralNavigationLabel = 'Votos Finalizados';

    protected static ?string $navigationGroup = 'Municipios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVotos::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getWidgets(): array
    {
        return [
            VotoOverview::class,
        ];
    }
}
