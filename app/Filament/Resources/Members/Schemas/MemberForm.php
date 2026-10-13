<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('member_no')
                    ->required(),
                TextInput::make('nik'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('department'),
                TextInput::make('savings_balance')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('credit_limit')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
