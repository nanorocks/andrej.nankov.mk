<?php

namespace App\Repositories;

use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

class PassportClientRepository extends ClientRepository
{
    /**
     * Update all by the given attribute.
     */
    public function updateAllByAttribute($userId, string $attribute, $value)
    {
        $client = Passport::client();

        return $client->where('user_id', $userId)->where('revoked', true)->update([$attribute => $value]);

        $client->forceFill([$attribute => $value])->save();

        return $client;
    }
}
