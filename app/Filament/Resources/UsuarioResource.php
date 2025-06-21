<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsuarioResource\Pages;
use App\Models\Usuario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class UsuarioResource extends Resource
{
    protected static ?string $model = Usuario::class;

    protected static ?string $navigationLabel = 'Usuarios';

    protected static ?string $pluralNavigationLabel = 'Usuarios';

    protected static ?string $navigationGroup = 'Candidaturas';
    protected static ?string $recordTitleAttribute = 'correo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido_paterno')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido_materno')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cedula_identidad')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contrasena_hash')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('correo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('fecha_nacimiento')
                    ->required(),
                Forms\Components\Select::make('rol_id')
                    ->relationship('rol', 'tipo_rol')
                    ->preload()
                    ->required(),
                Forms\Components\Toggle::make('is_deleted')
                    ->required(),
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
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cedula_identidad')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_deleted')
                    ->label('Eliminado')
                    ->alignCenter()
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

    public static function getWidgets(): array
    {
        return [
            UsuarioResource\Widgets\UsuariosOverview::class,
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
