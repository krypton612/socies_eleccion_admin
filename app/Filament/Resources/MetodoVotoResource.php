<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetodoVotoResource\Pages;
use App\Models\MetodoVoto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MetodoVotoResource extends Resource
{
    protected static ?string $model = MetodoVoto::class;

    protected static ?string $navigationLabel = 'Métodos de Voto';

    protected static ?string $pluralNavigationLabel = 'Métodos de Voto';

    protected static ?string $navigationGroup = 'Municipios';
    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-map-pin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->icon('heroicon-o-clock'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->icon('heroicon-o-arrow-path'),
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
            'index' => Pages\ListMetodoVotos::route('/'),
            'create' => Pages\CreateMetodoVoto::route('/create'),
            'edit' => Pages\EditMetodoVoto::route('/{record}/edit'),
        ];
    }
}
