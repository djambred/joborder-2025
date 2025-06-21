<?php

namespace App\Filament\Admin\Resources\ObjectiveResource\Pages;

use App\Filament\Admin\Resources\ObjectiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditObjective extends EditRecord
{
    protected static string $resource = ObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
