<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstadoCandidatoResource\Pages;
use App\Filament\Resources\EstadoCandidatoResource\RelationManagers;
use App\Models\EstadoCandidato;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstadoCandidatoResource extends Resource
{
    protected static ?string $model = EstadoCandidato::class;

    protected static ?string $navigationLabel = 'Estado de candidatos';

    protected static ?string $pluralNavigationLabel = 'Estado de candidatos';

    protected static ?string $navigationGroup = 'Candidatos';

    protected static ?string $recordTitleAttribute = 'estado_candidato';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('estado_candidato')
                    ->label('Estado')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estado_candidato')
                    ->label('Estado')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->searchable()
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
            'index' => Pages\ListEstadoCandidatos::route('/'),
            'create' => Pages\CreateEstadoCandidato::route('/create'),
            'edit' => Pages\EditEstadoCandidato::route('/{record}/edit'),
        ];
    }
}
