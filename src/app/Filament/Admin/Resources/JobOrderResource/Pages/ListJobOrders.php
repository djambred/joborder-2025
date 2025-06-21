<?php

namespace App\Filament\Admin\Resources\JobOrderResource\Pages;

use App\Filament\Admin\Resources\JobOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobOrders extends ListRecords
{
    protected static string $resource = JobOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
