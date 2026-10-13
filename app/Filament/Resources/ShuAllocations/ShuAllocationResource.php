<?php

namespace App\Filament\Resources\ShuAllocations;

use App\Filament\Resources\ShuAllocations\Pages\CreateShuAllocation;
use App\Filament\Resources\ShuAllocations\Pages\EditShuAllocation;
use App\Filament\Resources\ShuAllocations\Pages\ListShuAllocations;
use App\Filament\Resources\ShuAllocations\Schemas\ShuAllocationForm;
use App\Filament\Resources\ShuAllocations\Tables\ShuAllocationsTable;
use App\Models\ShuAllocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ShuAllocationResource extends Resource
{
    protected static ?string $model = ShuAllocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ShuAllocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShuAllocationsTable::configure($table);
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
            'index' => ListShuAllocations::route('/'),
            'create' => CreateShuAllocation::route('/create'),
            'edit' => EditShuAllocation::route('/{record}/edit'),
        ];
    }
}
