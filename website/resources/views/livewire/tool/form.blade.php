<div class="space-y-6 pl-1">

    <div>
        <x-input-label for="title" :value="__('Title')"/>
        <x-text-input wire:model="form.title" id="title" name="title" type="text" class="mt-1 block w-full" autocomplete="title" placeholder="Title"/>
        @error('form.title')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="slug" :value="__('Slug')"/>
        <x-text-input wire:model="form.slug" id="slug" name="slug" type="text" class="mt-1 block w-full" autocomplete="slug" placeholder="Slug"/>
        @error('form.slug')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <x-text-input wire:model="form.description" id="description" name="description" type="text" class="mt-1 block w-full" autocomplete="description" placeholder="Description"/>
        @error('form.description')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="photo_url" :value="__('Photo Url')"/>
        <x-text-input wire:model="form.photo_url" id="photo_url" name="photo_url" type="text" class="mt-1 block w-full" autocomplete="photo_url" placeholder="Photo Url"/>
        @error('form.photo_url')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="caption" :value="__('Caption')"/>
        <x-text-input wire:model="form.caption" id="caption" name="caption" type="text" class="mt-1 block w-full" autocomplete="caption" placeholder="Caption"/>
        @error('form.caption')
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

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
