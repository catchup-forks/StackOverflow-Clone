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
            Section::make(trans('stackoverflow.admin.vote.form.section'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(trans('stackoverflow.admin.vote.form.post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('user_id')
                        ->label(trans('stackoverflow.admin.vote.form.user'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('vote_type_id')
                        ->label(trans('stackoverflow.admin.vote.form.type'))
                        ->options(collect(VoteType::cases())->mapWithKeys(
                            fn (VoteType $type) => [
                                $type->value => trans('stackoverflow.vote_types.' . $type->name),
                            ]
                        ))
                        ->required(),
                    TextInput::make('bounty_amount')
                        ->label(trans('stackoverflow.admin.vote.form.bounty_amount'))
                        ->numeric()
                        ->default(0),
                    DateTimePicker::make('creation_date')
                        ->label(trans('stackoverflow.admin.vote.form.cast_at'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                ]),
        ];
    }
}
