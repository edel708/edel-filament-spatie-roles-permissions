<?php

namespace Althinect\FilamentSpatieRolesPermissions\Resources\Users\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.name'))
                    ->required()
                    ->columnSpan([
                        'sm' => 12,
                        'md' => 4,
                    ]),

                TextInput::make('email')
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.email'))
                    ->email()
                    ->required()
                    ->columnSpan([
                        'sm' => 12,
                        'md' => 4,
                    ]),

                Group::make()
                    ->schema([
                        TextEntry::make('email_verified_at')
                            ->label(__('filament-spatie-roles-permissions::filament-spatie.field.email_verified_at'))
                            ->visible(fn ($record): bool => $record?->email_verified_at !== null)
                            ->formatStateUsing(function ($state, $record) {
                                return Carbon::parse($record->email_verified_at)->format('d/m/Y H:i');
                            })
                            ->badge()
                            ->color(fn ($record): string =>
                                $record?->email_verified_at ? 'success' : 'warning'
                            )
                            ->icon(fn ($record): string =>
                                $record?->email_verified_at ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'
                            ),

                        TextEntry::make('not_verified_message')
                            ->label(__('filament-spatie-roles-permissions::filament-spatie.not_verified_message'))
                            ->visible(fn ($record): bool => $record?->email_verified_at === null)
                            ->default(__('filament-spatie-roles-permissions::filament-spatie.not_verified'))
                            ->badge()
                            ->color('warning')
                            ->icon('heroicon-o-clock'),
                    ])
                    ->columnSpan([
                        'sm' => 12,
                        'md' => 4,
                    ]),

                Select::make('roles')
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.roles'))
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable(['name'])
                    ->native()
                    ->searchPrompt(__('filament-spatie-roles-permissions::filament-spatie.select_roles'))
                    ->columnSpanFull(),

                CheckboxList::make('permissions')
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.permissions'))
                    ->relationship('permissions', 'name')
                    ->searchable()
                    ->columnSpanFull(),
            ])
            ->columns([
                'sm' => 12,
                'md' => 12,
                'lg' => 12,
                'xl' => 12,
            ]);
    }
}
