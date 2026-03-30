<?php

namespace Althinect\FilamentSpatieRolesPermissions\Resources\Users\Tables;

use App\Models\User;
use EdelRojas\DateFormatter\Columns\SmartDateColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.name'))
                    ->searchable(),

                TextColumn::make('email')
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.email'))
                    ->searchable(),

                TextColumn::make('email_verified_at')
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.email_verified_at'))
                    ->default(__('filament-spatie-roles-permissions::filament-spatie.field.email_unverified'))
                    ->formatStateUsing(function ($state, $record): string {
                        if ($record->email_verified_at) {
                            $date = $record->email_verified_at->format('d/m/Y H:i');

                            return __('filament-spatie-roles-permissions::filament-spatie.verified') . " ({$date})";
                        }

                        return __('filament-spatie-roles-permissions::filament-spatie.not_verified');
                    })
                    ->badge()
                    ->color(fn ($record): string =>
                        $record->email_verified_at ? 'success' : 'warning'
                    )
                    ->icon(fn ($record): string =>
                        $record->email_verified_at ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'
                    ),

                TextColumn::make('roles.name')
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.roles'))
                    ->badge()
                    ->color('success'),

                SmartDateColumn::make('created_at')
                    ->forPost('full')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                SmartDateColumn::make('updated_at')
                    ->forPost('full')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                DeleteAction::make()
                    ->visible(fn (User $record): bool =>
                        $record->name !== 'Admin' && $record->id !== auth()->user()->id
                    )
                    ->modalHeading(__('filament-spatie-roles-permissions::filament-spatie.delete_title'))
                    ->modalDescription(__('filament-spatie-roles-permissions::filament-spatie.delete_description'))
                    ->modalSubmitActionLabel(__('filament-spatie-roles-permissions::filament-spatie.delete_confirm'))
                    ->color('danger')
                    ->action(function (DeleteAction $action, User $record) {
                        try {
                            $record->delete();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->danger()
                                ->title(__('filament-spatie-roles-permissions::filament-spatie.delete_error_title'))
                                ->body($e->getMessage())
                                ->persistent()
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function (DeleteBulkAction $action, $records) {
                            foreach ($records as $record) {
                                if ($record->name === 'Admin') {
                                    Notification::make()
                                        ->danger()
                                        ->title(__('filament-spatie-roles-permissions::filament-spatie.delete_error_title'))
                                        ->body(__('filament-spatie-roles-permissions::filament-spatie.cannot_delete_admin'))
                                        ->send();

                                    $action->cancel();
                                    return;
                                }

                                if ($record->id === auth()->user()->id) {
                                    Notification::make()
                                        ->danger()
                                        ->title(__('filament-spatie-roles-permissions::filament-spatie.delete_error_title'))
                                        ->body(__('filament-spatie-roles-permissions::filament-spatie.cannot_delete_self'))
                                        ->send();

                                    $action->cancel();
                                    return;
                                }
                            }
                        }),
                ]),
            ]);
    }
}
