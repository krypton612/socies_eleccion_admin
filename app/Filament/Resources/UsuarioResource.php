<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsuarioResource\Pages;
use App\Filament\Resources\UsuarioResource\RelationManagers;
use App\Models\Usuario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsuarioResource extends Resource
{
    protected static ?string $model = Usuario::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('nombre_completo')
                ->badge()
                ->searchable(),
                Tables\Columns\TextColumn::make('correo')
                ->searchable(),
                Tables\Columns\IconColumn::make('is_deleted')
                ->label('Eliminado')
                ->alignCenter()
                ->boolean()
                ->searchable(),
                Tables\Columns\IconColumn::make('estado')
                ->label('¿Puede votar?')
                ->alignCenter()
                ->boolean()
                ->searchable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')
                ->searchable(),
                Tables\Columns\TextColumn::make('rol.tipo_rol')
                ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                ->toggleable(isToggledHiddenByDefault: true)
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
            'index' => Pages\ListUsuarios::route('/'),
            'create' => Pages\CreateUsuario::route('/create'),
            'edit' => Pages\EditUsuario::route('/{record}/edit'),
        ];
    }
}
