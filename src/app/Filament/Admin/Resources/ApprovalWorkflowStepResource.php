<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ApprovalWorkflowStepResource\Pages;
use App\Filament\Admin\Resources\ApprovalWorkflowStepResource\RelationManagers;
use App\Models\ApprovalWorkflowStep;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApprovalWorkflowStepResource extends Resource
{
    protected static ?string $model = ApprovalWorkflowStep::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('approval_workflow_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('step')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('position_id')
                    ->relationship('position', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('approval_workflow_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('step')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position.name')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListApprovalWorkflowSteps::route('/'),
            'create' => Pages\CreateApprovalWorkflowStep::route('/create'),
            'edit' => Pages\EditApprovalWorkflowStep::route('/{record}/edit'),
        ];
    }
}
