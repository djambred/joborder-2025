<?php

namespace App\Filament\Admin\Resources\JobOrderResource\Pages;

use App\Filament\Admin\Resources\JobOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJobOrder extends CreateRecord
{
    protected static string $resource = JobOrderResource::class;
}
