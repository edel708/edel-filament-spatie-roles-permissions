<?php

namespace Althinect\FilamentSpatieRolesPermissions\Resources\Users;

use Althinect\FilamentSpatieRolesPermissions\Models\User;
use Althinect\FilamentSpatieRolesPermissions\Resources\Users\Pages\CreateUser;
use Althinect\FilamentSpatieRolesPermissions\Resources\Users\Pages\EditUser;
use Althinect\FilamentSpatieRolesPermissions\Resources\Users\Pages\ListUsers;
use Althinect\FilamentSpatieRolesPermissions\Resources\Users\Pages\ViewUser;
use Althinect\FilamentSpatieRolesPermissions\Resources\Users\Schemas\UserForm;
use Althinect\FilamentSpatieRolesPermissions\Resources\Users\Schemas\UserInfolist;
use Althinect\FilamentSpatieRolesPermissions\Resources\Users\Tables\UsersTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = null;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $recordTitleAttribute = 'name';

    protected static bool $shouldRegisterNavigation = true;

    public static function isScopedToTenant(): bool
    {
        return config('filament-spatie-roles-permissions.scope_user_to_tenant', config('filament-spatie-roles-permissions.scope_to_tenant', true));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
        return config('filament-spatie-roles-permissions.should_register_on_navigation.users', true);
    }

    public static function getModel(): string
    {
        return config('permission.models.user', User::class);
    }

    public static function getLabel(): string
    {
        return __('filament-spatie-roles-permissions::filament-spatie.section.permission');
    }

    public static function getNavigationGroup(): ?string
    {
        return __(config('filament-spatie-roles-permissions.navigation_section_group', 'filament-spatie-roles-permissions::filament-spatie.section.roles_and_permissions'));
    }

    public static function getNavigationSort(): ?int
    {
        return  config('filament-spatie-roles-permissions.sort.user_navigation');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-spatie-roles-permissions::filament-spatie.section.users');
    }

    public static function getCluster(): ?string
    {
        return config('filament-spatie-roles-permissions.clusters.users', null);
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

}
