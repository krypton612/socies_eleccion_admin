<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstadoProcesoResource\Pages;
use App\Filament\Resources\EstadoProcesoResource\RelationManagers;
use App\Models\EstadoProceso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstadoProcesoResource extends Resource
{
    protected static ?string $model = EstadoProceso::class;

    protected static ?string $navigationLabel = 'Estado de procesos';

    protected static ?string $pluralNavigationLabel = 'Estado de procesos';

    protected static ?string $navigationGroup = 'Elecciones';

    protected static ?string $recordTitleAttribute = 'estado_proceso';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('estado_proceso')
                    ->label('Estado')
                    ->required()
                    ->prefixIcon('heroicon-o-flag')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estado_proceso')
                    ->label('Estado')
                    ->searchable()
                    ->icon('heroicon-o-flag')
                    ->badge()
                    ->color('success')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->searchable(),
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
            'index' => Pages\ListEstadoProcesos::route('/'),
            'create' => Pages\CreateEstadoProceso::route('/create'),
            'edit' => Pages\EditEstadoProceso::route('/{record}/edit'),
        ];
    }
}
