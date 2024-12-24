<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryResource\Pages;
use App\Filament\Resources\SalaryResource\RelationManagers;
use App\Models\Salary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('employee_id')
                ->label('Employee ID')
                ->required()
                ->placeholder('Enter Employee ID'),

                TextInput::make('basic_salary')
                ->label('Basic Salary')
                ->numeric()
                ->required()
                ->placeholder('Enter Basic Salary')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $basicSalary = (float) $state ?: 0;
                    $allowance = (float) $get('allowance') ?: 0;
                    $deduction = (float) $get('deduction') ?: 0;
                    $set('total_salary', $basicSalary + $allowance - $deduction);
                }),
            
            TextInput::make('allowance')
                ->label('Allowance')
                ->numeric()
                ->placeholder('Enter Allowance Amount')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $basicSalary = (float) $get('basic_salary') ?: 0;
                    $allowance = (float) $state ?: 0;
                    $deduction = (float) $get('deduction') ?: 0;
                    $set('total_salary', $basicSalary + $allowance - $deduction);
                }),
            
            TextInput::make('deduction')
                ->label('Deduction')
                ->numeric()
                ->placeholder('Enter Deduction Amount')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $basicSalary = (float) $get('basic_salary') ?: 0;
                    $allowance = (float) $get('allowance') ?: 0;
                    $deduction = (float) $state ?: 0;
                    $set('total_salary', $basicSalary + $allowance - $deduction);
                }),

            TextInput::make('total_salary')
                ->label('Total Salary')
                ->numeric()
                ->placeholder('Total Salary will be calculated')
                ->disabled()
                ->dehydrateStateUsing(function ($state, $get) {
                    $basicSalary = (float) $get('basic_salary') ?: 0;
                    $allowance = (float) $get('allowance') ?: 0;
                    $deduction = (float) $get('deduction') ?: 0;

                    return $basicSalary + $allowance - $deduction;
                    
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            TextColumn::make('employee_id')
                ->label('Employee ID')
                ->sortable()
                ->searchable(),

            TextColumn::make('basic_salary')
                ->label('Basic Salary')
                ->sortable()
                ->formatStateUsing(fn ($state) => number_format($state, 2)),

            TextColumn::make('allowance')
                ->label('Allowance')
                ->sortable()
                ->formatStateUsing(fn ($state) => number_format($state, 2)),

            TextColumn::make('deduction')
                ->label('Deduction')
                ->sortable()
                ->formatStateUsing(fn ($state) => number_format($state, 2)),

            TextColumn::make('total_salary')
                ->label('Total Salary')
                ->sortable()
                ->formatStateUsing(fn ($state) => number_format($state, 2)),
        ])
        ->filters([
            // Add any filters if needed
        ])
        ->actions([
            EditAction::make(),
        ])
        ->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
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
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
        ];
    }
}
