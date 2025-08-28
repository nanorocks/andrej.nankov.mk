<?php

namespace App\Services;

use App\Models\PluginDatabaseNewsletterLicense;


class PluginDatabaseNewsletterLicenseService
{
    /**
     * Validate a license key
     */
    public function validateLicense(string $licenseKey): bool
    {
        $license = PluginDatabaseNewsletterLicense::where('license_key', $licenseKey)->first();
        return $license ? $license->isValid() : false;
    }

    /**
     * Assign license to user/email
     */
    public function assignLicense(string $licenseKey, string $assignedTo): bool
    {
        $license = PluginDatabaseNewsletterLicense::where('license_key', $licenseKey)->first();
        if (! $license) return false;

        $license->assigned_to = $assignedTo;
        $license->save();
        return true;
    }

    /**
     * Create new license
     */
    public function createLicense(array $data): PluginDatabaseNewsletterLicense
    {
        return PluginDatabaseNewsletterLicense::create($data);
    }

    /**
     * Deactivate license
     */
    public function deactivateLicense(string $licenseKey): bool
    {
        $license = PluginDatabaseNewsletterLicense::where('license_key', $licenseKey)->first();
        if (! $license) return false;

        $license->active = false;
        $license->save();
        return true;
    }
}
