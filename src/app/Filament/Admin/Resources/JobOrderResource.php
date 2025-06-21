<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JobOrderResource\Pages;
use App\Filament\Admin\Resources\JobOrderResource\RelationManagers;
use App\Models\JobOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobOrderResource extends Resource
{
    protected static ?string $model = JobOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('job_order_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('job_order_date')
                    ->required(),
                Forms\Components\Textarea::make('work_description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('work_type')
                    ->required(),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required(),
                Forms\Components\Select::make('requester_id')
                    ->relationship('requester', 'id')
                    ->required(),
                Forms\Components\Select::make('recipient_id')
                    ->relationship('recipient', 'id')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('pending_approval'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job_order_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_order_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('work_type'),
                Tables\Columns\TextColumn::make('department.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('requester.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('recipient.id')

                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('viewDetails')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Job Order Detail')
                    ->modalButton('Close')
                    ->modalSubmitAction(false) // read-only modal
                    ->form(fn (JobOrder $record) => [
                        Forms\Components\Placeholder::make('job_order_number')
                            ->content($record->job_order_number),

                        Forms\Components\Placeholder::make('job_order_date')
                            ->content($record->job_order_date),

                        Forms\Components\Placeholder::make('status')
                            ->content(strtoupper($record->status)),

                        Forms\Components\Placeholder::make('requester')
                            ->content(optional($record->requester?->user)->name),

                        Forms\Components\Placeholder::make('objectives')
                            ->label('Objectives')
                            ->content(fn () => $record->objectives->pluck('name')->join(', ')),

                        Forms\Components\Placeholder::make('description')
                            ->label('Work Description')
                            ->content($record->work_description),
                    ]),

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
            'index' => Pages\ListJobOrders::route('/'),
            'create' => Pages\CreateJobOrder::route('/create'),
            'edit' => Pages\EditJobOrder::route('/{record}/edit'),
        ];
    }
}
