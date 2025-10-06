<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\VehicleAttribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehicleAttributePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:VehicleAttribute');
    }

    public function view(AuthUser $authUser, VehicleAttribute $vehicleAttribute): bool
    {
        return $authUser->can('View:VehicleAttribute');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:VehicleAttribute');
    }

    public function update(AuthUser $authUser, VehicleAttribute $vehicleAttribute): bool
    {
        return $authUser->can('Update:VehicleAttribute');
    }

    public function delete(AuthUser $authUser, VehicleAttribute $vehicleAttribute): bool
    {
        return $authUser->can('Delete:VehicleAttribute');
    }

    public function restore(AuthUser $authUser, VehicleAttribute $vehicleAttribute): bool
    {
        return $authUser->can('Restore:VehicleAttribute');
    }

    public function forceDelete(AuthUser $authUser, VehicleAttribute $vehicleAttribute): bool
    {
        return $authUser->can('ForceDelete:VehicleAttribute');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:VehicleAttribute');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:VehicleAttribute');
    }

    public function replicate(AuthUser $authUser, VehicleAttribute $vehicleAttribute): bool
    {
        return $authUser->can('Replicate:VehicleAttribute');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:VehicleAttribute');
    }

}