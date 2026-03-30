<?php

namespace Althinect\FilamentSpatieRolesPermissions\Resources\Users\Pages;

use Althinect\FilamentSpatieRolesPermissions\Resources\Users\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

}
