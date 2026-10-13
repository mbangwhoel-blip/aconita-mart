<?php

namespace App\Filament\Resources\Purchases\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('supplier_id')
                    ->relationship('supplier', 'name'),
                TextInput::make('invoice_no')
                    ->required(),
                DatePicker::make('purchase_date')
                    ->required(),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('payment_status')
                    ->required()
                    ->default('paid'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
