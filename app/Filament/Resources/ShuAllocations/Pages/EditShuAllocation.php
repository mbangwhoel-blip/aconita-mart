<?php

namespace App\Filament\Resources\ShuAllocations\Pages;

use App\Filament\Resources\ShuAllocations\ShuAllocationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditShuAllocation extends EditRecord
{
    protected static string $resource = ShuAllocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
