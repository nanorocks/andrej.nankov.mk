<div class="space-y-6">

    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input wire:model="form.name" id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" placeholder="Name"/>
        @error('form.name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="avatar" :value="__('Avatar')"/>
        <x-text-input wire:model="form.avatar" id="avatar" name="avatar" type="text" class="mt-1 block w-full" autocomplete="avatar" placeholder="Avatar"/>
        @error('form.avatar')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')"/>
        <x-text-input wire:model="form.email" id="email" name="email" type="text" class="mt-1 block w-full" autocomplete="email" placeholder="Email"/>
        @error('form.email')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="phone_number" :value="__('Phone Number')"/>
        <x-text-input wire:model="form.phone_number" id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" autocomplete="phone_number" placeholder="Phone Number"/>
        @error('form.phone_number')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="address" :value="__('Address')"/>
        <x-text-input wire:model="form.address" id="address" name="address" type="text" class="mt-1 block w-full" autocomplete="address" placeholder="Address"/>
        @error('form.address')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="website_url" :value="__('Website Url')"/>
        <x-text-input wire:model="form.website_url" id="website_url" name="website_url" type="text" class="mt-1 block w-full" autocomplete="website_url" placeholder="Website Url"/>
        @error('form.website_url')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="medium_url" :value="__('Medium Url')"/>
        <x-text-input wire:model="form.medium_url" id="medium_url" name="medium_url" type="text" class="mt-1 block w-full" autocomplete="medium_url" placeholder="Medium Url"/>
        @error('form.medium_url')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="social_media" :value="__('Social Media')"/>
        <x-text-input wire:model="form.social_media" id="social_media" name="social_media" type="text" class="mt-1 block w-full" autocomplete="social_media" placeholder="Social Media"/>
        @error('form.social_media')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="role" :value="__('Role')"/>
        <x-text-input wire:model="form.role" id="role" name="role" type="text" class="mt-1 block w-full" autocomplete="role" placeholder="Role"/>
        @error('form.role')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="bio" :value="__('Bio')"/>
        <x-text-input wire:model="form.bio" id="bio" name="bio" type="text" class="mt-1 block w-full" autocomplete="bio" placeholder="Bio"/>
        @error('form.bio')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
