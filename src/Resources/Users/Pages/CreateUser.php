<?php

namespace Althinect\FilamentSpatieRolesPermissions\Resources\Users\Pages;

use Althinect\FilamentSpatieRolesPermissions\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Hashear la contraseña antes de guardar
        $password = Str::random(12);
        $data['password'] = Hash::make('12345678');

        return $data;
    }
}
