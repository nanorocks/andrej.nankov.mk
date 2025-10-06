<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\VehicleService;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehicleServicePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:VehicleService');
    }

    public function view(AuthUser $authUser, VehicleService $vehicleService): bool
    {
        return $authUser->can('View:VehicleService');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:VehicleService');
    }

    public function update(AuthUser $authUser, VehicleService $vehicleService): bool
    {
        return $authUser->can('Update:VehicleService');
    }

    public function delete(AuthUser $authUser, VehicleService $vehicleService): bool
    {
        return $authUser->can('Delete:VehicleService');
    }

    public function restore(AuthUser $authUser, VehicleService $vehicleService): bool
    {
        return $authUser->can('Restore:VehicleService');
    }

    public function forceDelete(AuthUser $authUser, VehicleService $vehicleService): bool
    {
        return $authUser->can('ForceDelete:VehicleService');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:VehicleService');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:VehicleService');
    }

    public function replicate(AuthUser $authUser, VehicleService $vehicleService): bool
    {
        return $authUser->can('Replicate:VehicleService');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:VehicleService');
    }

}