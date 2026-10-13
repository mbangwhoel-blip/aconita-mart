<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_no')
                    ->searchable(),
                TextColumn::make('member.name')
                    ->searchable(),
                TextColumn::make('cashier.name')
                    ->searchable(),
                TextColumn::make('order_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('discount_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('final_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('paid_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('change_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->searchable(),
                TextColumn::make('total_profit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
