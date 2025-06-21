<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JobOrderApprovalResource\Pages;
use App\Models\JobOrderApproval;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobOrderApprovalResource extends Resource
{
    protected static ?string $model = JobOrderApproval::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('job_order_id')
                ->relationship('jobOrder', 'job_order_number')
                ->label('Job Order')
                ->required(),

            Forms\Components\TextInput::make('approval_workflow_step_id')
                ->label('Step')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('employee_id')
                ->label('Approver')
                ->disabled()
                ->dehydrated(false)
                ->default(fn ($record) => optional($record?->employee?->user)->name),

            Forms\Components\TextInput::make('status')
                ->disabled()
                ->dehydrated(false),

            Forms\Components\Textarea::make('comments')
                ->columnSpanFull(),

            Forms\Components\DateTimePicker::make('approved_at')
                ->disabled()
                ->dehydrated(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jobOrder.job_order_number')
                    ->label('Job Order')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('approvalWorkflowStep.step')
                    ->label('Step')
                    ->sortable(),

                Tables\Columns\TextColumn::make('approvalWorkflowStep.position.name')
                    ->label('Required Position')
                    ->sortable(),

                Tables\Columns\TextColumn::make('employee.user.name')
                    ->label('Approved By')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime()
                    ->sortable(),

                // Optional: Debug column to show visibility logic
                Tables\Columns\TextColumn::make('canApprove')
                    ->label('Can Approve?')
                    ->getStateUsing(fn ($record) => $record->canBeApprovedBy(auth()->user()) ? '✅' : '❌')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->canBeApprovedBy(auth()->user()))
                    ->action(function ($record) {
                        $record->approve(auth()->user()->employee);
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->canBeApprovedBy(auth()->user()))
                    ->action(function ($record) {
                        $record->reject(auth()->user()->employee);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobOrderApprovals::route('/'),
            'create' => Pages\CreateJobOrderApproval::route('/create'),
            'edit' => Pages\EditJobOrderApproval::route('/{record}/edit'),
        ];
    }
}
