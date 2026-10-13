<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_no')
                    ->required(),
                Select::make('member_id')
                    ->relationship('member', 'name'),
                Select::make('cashier_id')
                    ->relationship('cashier', 'name'),
                DateTimePicker::make('order_date')
                    ->required(),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('final_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('paid_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('change_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('payment_method')
                    ->required()
                    ->default('cash'),
                TextInput::make('payment_status')
                    ->required()
                    ->default('paid'),
                TextInput::make('total_profit')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
