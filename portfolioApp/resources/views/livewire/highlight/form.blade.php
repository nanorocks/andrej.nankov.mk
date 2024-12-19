<div class="space-y-6">
    
    <div>
        <x-input-label for="year" :value="__('Year')"/>
        <x-text-input wire:model="form.year" id="year" name="year" type="text" class="mt-1 block w-full" autocomplete="year" placeholder="Year"/>
        @error('form.year')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="event" :value="__('Event')"/>
        <x-text-input wire:model="form.event" id="event" name="event" type="text" class="mt-1 block w-full" autocomplete="event" placeholder="Event"/>
        @error('form.event')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>