<?php

namespace App\Filament\Resources\ShuAllocations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ShuAllocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('total_revenue')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_profit')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('member_share_percentage')
                    ->required()
                    ->numeric()
                    ->default(50.0),
                TextInput::make('member_shu_pool')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
