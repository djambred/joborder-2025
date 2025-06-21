<?php

namespace App\Filament\Admin\Resources\JobOrderResource\Pages;

use App\Filament\Admin\Resources\JobOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobOrder extends EditRecord
{
    protected static string $resource = JobOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
