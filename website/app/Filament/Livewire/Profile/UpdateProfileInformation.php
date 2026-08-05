<?php

namespace App\Filament\Livewire\Profile;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Jetstream\Jetstream;
use Filament\Jetstream\Livewire\Profile\UpdateProfileInformation as BaseUpdateProfileInformation;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateProfileInformation extends BaseUpdateProfileInformation
{
    public function mount(): void
    {
        $user = $this->authUser();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'profile_photo_path' => $user->profile_photo_path,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('filament-jetstream::default.update_profile_information.section.title'))
                    ->aside()
                    ->description(__('filament-jetstream::default.update_profile_information.section.description'))
                    ->schema([
                        FileUpload::make('profile_photo_path')
                            ->label(__('filament-jetstream::default.form.profile_photo.label'))
                            ->avatar()
                            ->image()
                            ->imageEditor()
                            ->visibility('public')
                            ->directory('profile-photos')
                            ->disk(fn (): string => Jetstream::plugin()?->profilePhotoDisk() ?? 'public')
                            ->fetchFileInformation(false)
                            ->visible(fn (): bool => (bool) Jetstream::plugin()?->managesProfilePhotos()),
                        TextInput::make('name')
                            ->label(__('filament-jetstream::default.form.name.label'))
                            ->string()
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('email')
                            ->label(__('filament-jetstream::default.form.email.label'))
                            ->email()
                            ->required()
                            ->unique(get_class(Filament::auth()->user()), ignorable: $this->authUser()),
                        Actions::make([
                            Action::make('save')
                                ->label(__('filament-jetstream::default.action.save.label'))
                                ->submit('updateProfile'),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function updateProfile(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->sendRateLimitedNotification($exception);

            return;
        }

        $diskName = Jetstream::plugin()?->profilePhotoDisk() ?? 'public';

        try {
            $disk = Storage::disk($diskName);
            if (! $disk->exists('profile-photos')) {
                $disk->makeDirectory('profile-photos');
            }
        } catch (\Throwable $e) {
            Log::warning('Could not prepare profile-photos directory', [
                'disk' => $diskName,
                'error' => $e->getMessage(),
            ]);
        }

        $data = $this->form->getState();
        $user = $this->authUser();

        $newPhotoPath = $data['profile_photo_path'] ?? null;
        $isUpdatingEmail = $data['email'] !== $user->email;
        $isUpdatingPhoto = $newPhotoPath !== $user->profile_photo_path;

        $user->forceFill(Arr::except($data, ['profile_photo_path']))->save();

        if ($isUpdatingEmail) {
            $user->forceFill(['email_verified_at' => null]);
            $user->sendEmailVerificationNotification();
        }

        if ($isUpdatingPhoto) {
            try {
                $newPhotoPath
                    ? $user->updateProfilePhoto($newPhotoPath)
                    : $user->deleteProfilePhoto();
            } catch (\Throwable $e) {
                Log::error('Profile photo update failed', [
                    'user_id' => $user->id,
                    'disk' => $diskName,
                    'attempted_path' => $newPhotoPath,
                    'error' => $e->getMessage(),
                ]);

                throw $e;
            }
        }

        $this->sendNotification();
    }
}
