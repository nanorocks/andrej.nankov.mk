<div class="space-y-6 pl-1">

    <div>
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input wire:model="form.title" id="title" name="title" type="text" class="mt-1 block w-full"
            autocomplete="title" placeholder="Title" />
        @error('form.title')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="slug" :value="__('Slug')" />
        <x-text-input wire:model="form.slug" id="slug" name="slug" type="text" class="mt-1 block w-full"
            autocomplete="slug" placeholder="Slug" />
        @error('form.slug')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="url" :value="__('Url')" />
        <x-text-input wire:model="form.url" id="url" name="url" type="text" class="mt-1 block w-full"
            autocomplete="url" placeholder="Url" />
        @error('form.url')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="parent_id" :value="__('Parent Id')" />
        <x-text-input wire:model="form.parent_id" id="parent_id" name="parent_id" type="text"
            class="mt-1 block w-full" autocomplete="parent_id" placeholder="Parent Id" />
        @error('form.parent_id')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="order" :value="__('Order')" />
        <x-text-input wire:model="form.order" id="order" name="order" type="number" class="mt-1 block w-full"
            autocomplete="order" placeholder="Order" />
        @error('form.order')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
