<?php

namespace App\Filament\Admin\Resources\VoteResource\Schemas;

use App\Enums\VoteType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class VoteForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(__('Vote details'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(__('Post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('user_id')
                        ->label(__('User'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('vote_type_id')
                        ->label(__('Type'))
                        ->options(collect(VoteType::cases())->mapWithKeys(fn (VoteType $type) => [$type->value => __($type->name)]))
                        ->required(),
                    TextInput::make('bounty_amount')
                        ->label(__('Bounty amount'))
                        ->numeric()
                        ->default(0),
                    DateTimePicker::make('creation_date')
                        ->label(__('Cast at'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                ]),
        ];
    }
}
