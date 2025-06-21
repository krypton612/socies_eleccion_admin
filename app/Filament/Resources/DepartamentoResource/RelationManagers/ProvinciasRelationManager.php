<?php

namespace App\Filament\Resources\DepartamentoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProvinciasRelationManager extends RelationManager
{
    protected static string $relationship = 'provincias';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(50)
                    ->prefixIcon('heroicon-o-rectangle-stack')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                ->label('Nombre')
                ->searchable()
                ->sortable()
                ->weight('bold'),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Creado')
                ->icon('heroicon-o-clock')
                ->dateTime('d/m/Y H:i'),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Actualizado')
                ->icon('heroicon-o-arrow-path')
                ->dateTime('d/m/Y H:i'),
            Tables\Columns\TextColumn::make('departamento.nombre')
                ->label('Departamento')
                ->searchable()
                ->sortable()
                ->weight('bold'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
