<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name'),
                TextInput::make('barcode'),
                TextInput::make('sku')
                    ->label('SKU')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('unit')
                    ->required()
                    ->default('pcs'),
                TextInput::make('cost_price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp '),
                TextInput::make('selling_price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp '),
                TextInput::make('member_price')
                    ->numeric()
                    ->prefix('Rp '),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('min_stock')
                    ->required()
                    ->numeric()
                    ->default(5),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}

