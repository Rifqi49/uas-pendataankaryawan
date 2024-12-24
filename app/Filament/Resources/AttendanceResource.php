<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use FIlament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee_id')
                    ->label('Employee ID')
                    ->required()
                    ->placeholder('Enter Employee ID'),

                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->required()
                    ->placeholder('Select Attendance Date'),

                Forms\Components\Select::make('status')
                    ->label('Attendance Status')
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'on_leave' => 'On Leave',
                    ])
                    ->required()
                    ->placeholder('Select Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('employee_id')
                ->label('Employee ID')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('date')
                ->label('Date')
                ->sortable(),

            Tables\Columns\BadgeColumn::make('status')
            ->label('Status')
            ->formatStateUsing(fn ($state) => [
                'present' => 'Present',
                'absent' => 'Absent',
                'on_leave' => 'On Leave',
            ][$state] ?? $state)
            
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label('Filter by Status')
                ->options([
                    'present' => 'Present',
                    'absent' => 'Absent',
                    'on_leave' => 'On Leave',
                ]),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
