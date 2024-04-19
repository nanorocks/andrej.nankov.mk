<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{

    public function skipsAuthorization(): bool
    {
        return $this->firstParty();
    }
}
