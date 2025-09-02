<?php

namespace App\Filament\Resources\NewsletterPages\Pages;

use App\Filament\Resources\NewsletterPages\NewsletterPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletterPage extends CreateRecord
{
    protected static string $resource = NewsletterPageResource::class;
}
