<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Filament\Resources\PositionResource\RelationManagers;
use App\Models\Position;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Position Name')
                ->required()
                ->placeholder('Enter Position Name'),

            Forms\Components\TextInput::make('description')
                ->label('Description')
                ->placeholder('Enter Position Description'),

            Forms\Components\TextInput::make('basic_salary')
                ->label('Basic Salary')
                ->numeric()
                ->required()
                ->placeholder('Enter Basic Salary'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            Tables\Columns\TextColumn::make('name')
                ->label('Position Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('description')
                ->label('Description')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('basic_salary')
                ->label('Basic Salary')
                ->sortable()
                ->formatStateUsing(fn ($state) => number_format($state, 2)),
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
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}
