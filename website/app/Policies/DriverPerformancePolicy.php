<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DriverPerformance;
use Illuminate\Auth\Access\HandlesAuthorization;

class DriverPerformancePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DriverPerformance');
    }

    public function view(AuthUser $authUser, DriverPerformance $driverPerformance): bool
    {
        return $authUser->can('View:DriverPerformance');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DriverPerformance');
    }

    public function update(AuthUser $authUser, DriverPerformance $driverPerformance): bool
    {
        return $authUser->can('Update:DriverPerformance');
    }

    public function delete(AuthUser $authUser, DriverPerformance $driverPerformance): bool
    {
        return $authUser->can('Delete:DriverPerformance');
    }

    public function restore(AuthUser $authUser, DriverPerformance $driverPerformance): bool
    {
        return $authUser->can('Restore:DriverPerformance');
    }

    public function forceDelete(AuthUser $authUser, DriverPerformance $driverPerformance): bool
    {
        return $authUser->can('ForceDelete:DriverPerformance');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DriverPerformance');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DriverPerformance');
    }

    public function replicate(AuthUser $authUser, DriverPerformance $driverPerformance): bool
    {
        return $authUser->can('Replicate:DriverPerformance');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DriverPerformance');
    }

}