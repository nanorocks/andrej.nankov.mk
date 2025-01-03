<div class="space-y-6 pl-1">

    <div>
        <x-input-label for="slug" :value="__('Slug')" />
        <x-text-input wire:model="form.slug" id="slug" name="slug" type="text" class="mt-1 block w-full"
            autocomplete="slug" placeholder="Slug" />
        @error('form.slug')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="keywords" :value="__('Keywords')" />
        <x-text-input wire:model="form.keywords" id="keywords" name="keywords" type="text" class="mt-1 block w-full"
            autocomplete="keywords" placeholder="Keywords" />
        @error('form.keywords')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input wire:model="form.title" id="title" name="title" type="text" class="mt-1 block w-full"
            autocomplete="title" placeholder="Title" />
        @error('form.title')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="description" :value="__('Description')" />
        <x-text-input wire:model="form.description" id="description" name="description" type="text"
            class="mt-1 block w-full" autocomplete="description" placeholder="Description" />
        @error('form.description')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="meta_robots" :value="__('Meta Robots')" />
        <x-text-input wire:model="form.meta_robots" id="meta_robots" name="meta_robots" type="text"
            class="mt-1 block w-full" autocomplete="meta_robots" placeholder="Meta Robots" />
        @error('form.meta_robots')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="canonical_url" :value="__('Canonical Url')" />
        <x-text-input wire:model="form.canonical_url" id="canonical_url" name="canonical_url" type="text"
            class="mt-1 block w-full" autocomplete="canonical_url" placeholder="Canonical Url" />
        @error('form.canonical_url')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="og_title" :value="__('Og Title')" />
        <x-text-input wire:model="form.og_title" id="og_title" name="og_title" type="text" class="mt-1 block w-full"
            autocomplete="og_title" placeholder="Og Title" />
        @error('form.og_title')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="og_description" :value="__('Og Description')" />
        <x-text-input wire:model="form.og_description" id="og_description" name="og_description" type="text"
            class="mt-1 block w-full" autocomplete="og_description" placeholder="Og Description" />
        @error('form.og_description')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="og_image" :value="__('Og Image')" />
        <x-text-input wire:model="form.og_image" id="og_image" name="og_image" type="text" class="mt-1 block w-full"
            autocomplete="og_image" placeholder="Og Image" />
        @error('form.og_image')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="structured_data" :value="__('Structured Data')" />
        <x-text-input wire:model="form.structured_data" id="structured_data" name="structured_data" type="text"
            class="mt-1 block w-full" autocomplete="structured_data" placeholder="Structured Data" />
        @error('form.structured_data')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="locale" :value="__('Locale')" />
        <x-text-input wire:model="form.locale" id="locale" name="locale" type="text" class="mt-1 block w-full"
            autocomplete="locale" placeholder="Locale" />
        @error('form.locale')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="sitemap_priority" :value="__('Sitemap Priority')" />
        <x-text-input wire:model="form.sitemap_priority" id="sitemap_priority" name="sitemap_priority"
            type="text" class="mt-1 block w-full" autocomplete="sitemap_priority"
            placeholder="Sitemap Priority" />
        @error('form.sitemap_priority')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="sitemap_frequency" :value="__('Sitemap Frequency')" />
        <x-text-input wire:model="form.sitemap_frequency" id="sitemap_frequency" name="sitemap_frequency"
            type="text" class="mt-1 block w-full" autocomplete="sitemap_frequency"
            placeholder="Sitemap Frequency" />
        @error('form.sitemap_frequency')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="last_seo_audit" :value="__('Last Seo Audit')" />
        <x-text-input wire:model="form.last_seo_audit" id="last_seo_audit" name="last_seo_audit" type="text"
            class="mt-1 block w-full" autocomplete="last_seo_audit" placeholder="Last Seo Audit" />
        @error('form.last_seo_audit')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>
    <div>
        <x-input-label for="custom_scripts" :value="__('Custom Scripts')" />
        <x-text-input wire:model="form.custom_scripts" id="custom_scripts" name="custom_scripts" type="text"
            class="mt-1 block w-full" autocomplete="custom_scripts" placeholder="Custom Scripts" />
        @error('form.custom_scripts')
            <x-input-error class="mt-2" :messages="$message" />
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
