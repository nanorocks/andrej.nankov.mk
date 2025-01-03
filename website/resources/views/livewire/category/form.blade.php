<div class="space-y-6 pl-1">

    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input wire:model="form.name" id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" placeholder="Name"/>
        @error('form.name')
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
        <x-input-label for="parent_id" :value="__('Parent Id')"/>
        <x-text-input wire:model="form.parent_id" id="parent_id" name="parent_id" type="text" class="mt-1 block w-full" autocomplete="parent_id" placeholder="Parent Id"/>
        @error('form.parent_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="story_count" :value="__('Story Count')"/>
        <x-text-input wire:model="form.story_count" id="story_count" name="story_count" type="text" class="mt-1 block w-full" autocomplete="story_count" placeholder="Story Count"/>
        @error('form.story_count')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
