<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstadoCandidaturaResource\Pages;
use App\Filament\Resources\EstadoCandidaturaResource\RelationManagers;
use App\Models\EstadoCandidatura;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstadoCandidaturaResource extends Resource
{
    protected static ?string $model = EstadoCandidatura::class;

    protected static ?string $navigationLabel = 'Estado de candidaturas';

    protected static ?string $pluralNavigationLabel = 'Estado de candidaturas';

    protected static ?string $navigationGroup = 'Candidaturas';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('estado_candidatura')
                    ->label('Estado')
                    ->required()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-flag'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estado_candidatura')
                    ->label('Estado')
                    ->searchable()
                    ->icon('heroicon-o-flag')
                    ->badge()
                    ->color('success')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->icon('heroicon-o-clock')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->icon('heroicon-o-arrow-path')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListEstadoCandidaturas::route('/'),
            'create' => Pages\CreateEstadoCandidatura::route('/create'),
            'edit' => Pages\EditEstadoCandidatura::route('/{record}/edit'),
        ];
    }
}
