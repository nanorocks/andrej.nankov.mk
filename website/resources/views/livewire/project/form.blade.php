<div class="space-y-6 pl-1">

    <div>
        <x-input-label for="slug" :value="__('Slug')"/>
        <x-text-input wire:model="form.slug" id="slug" name="slug" type="text" class="mt-1 block w-full" autocomplete="slug" placeholder="Slug"/>
        @error('form.slug')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="title" :value="__('Title')"/>
        <x-text-input wire:model="form.title" id="title" name="title" type="text" class="mt-1 block w-full" autocomplete="title" placeholder="Title"/>
        @error('form.title')
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
        <x-input-label for="start_date" :value="__('Start Date')"/>
        <x-text-input wire:model="form.start_date" id="start_date" name="start_date" type="text" class="mt-1 block w-full" autocomplete="start_date" placeholder="Start Date"/>
        @error('form.start_date')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="end_date" :value="__('End Date')"/>
        <x-text-input wire:model="form.end_date" id="end_date" name="end_date" type="text" class="mt-1 block w-full" autocomplete="end_date" placeholder="End Date"/>
        @error('form.end_date')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="project_url" :value="__('Project Url')"/>
        <x-text-input wire:model="form.project_url" id="project_url" name="project_url" type="text" class="mt-1 block w-full" autocomplete="project_url" placeholder="Project Url"/>
        @error('form.project_url')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="image_url" :value="__('Image Url')"/>
        <x-text-input wire:model="form.image_url" id="image_url" name="image_url" type="text" class="mt-1 block w-full" autocomplete="image_url" placeholder="Image Url"/>
        @error('form.image_url')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="status" :value="__('Status')"/>
        <x-text-input wire:model="form.status" id="status" name="status" type="text" class="mt-1 block w-full" autocomplete="status" placeholder="Status"/>
        @error('form.status')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="user_id" :value="__('User Id')"/>
        <x-text-input wire:model="form.user_id" id="user_id" name="user_id" type="text" class="mt-1 block w-full" autocomplete="user_id" placeholder="User Id"/>
        @error('form.user_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
