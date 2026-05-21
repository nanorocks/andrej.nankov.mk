<?php

namespace App\Models;

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Jetstream\InteractsWIthProfile;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory;
    use InteractsWIthProfile;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function (): string {
            $path = $this->profile_photo_path;

            if ($path && ! Str::startsWith($path, ['http://', 'https://'])) {
                return Storage::disk($this->profilePhotoDisk())->url($path);
            }

            return $this->placeholderProfilePhotoUrl();
        });
    }

    protected function placeholderProfilePhotoUrl(): string
    {
        $localPlaceholder = public_path('images/avatar-placeholder.svg');

        if (is_file($localPlaceholder)) {
            return asset('images/avatar-placeholder.svg');
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64">'
            . '<rect width="64" height="64" rx="32" fill="#1f2937"/>'
            . '<g fill="#9ca3af">'
            . '<circle cx="32" cy="24" r="11"/>'
            . '<path d="M12 56c0-11.046 8.954-20 20-20s20 8.954 20 20v4H12v-4z"/>'
            . '</g></svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
