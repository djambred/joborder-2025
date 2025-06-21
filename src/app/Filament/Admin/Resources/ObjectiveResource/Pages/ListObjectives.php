<?php

namespace App\Filament\Admin\Resources\ObjectiveResource\Pages;

use App\Filament\Admin\Resources\ObjectiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListObjectives extends ListRecords
{
    protected static string $resource = ObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
