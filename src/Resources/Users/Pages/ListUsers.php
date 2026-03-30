<?php

namespace Althinect\FilamentSpatieRolesPermissions\Resources\Users\Pages;

use Althinect\FilamentSpatieRolesPermissions\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
