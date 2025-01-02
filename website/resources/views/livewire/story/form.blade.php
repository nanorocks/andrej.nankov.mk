<div class="space-y-6">
    
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
        <x-input-label for="content" :value="__('Content')"/>
        <x-text-input wire:model="form.content" id="content" name="content" type="text" class="mt-1 block w-full" autocomplete="content" placeholder="Content"/>
        @error('form.content')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="excerpt" :value="__('Excerpt')"/>
        <x-text-input wire:model="form.excerpt" id="excerpt" name="excerpt" type="text" class="mt-1 block w-full" autocomplete="excerpt" placeholder="Excerpt"/>
        @error('form.excerpt')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="author_id" :value="__('Author Id')"/>
        <x-text-input wire:model="form.author_id" id="author_id" name="author_id" type="text" class="mt-1 block w-full" autocomplete="author_id" placeholder="Author Id"/>
        @error('form.author_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="tags" :value="__('Tags')"/>
        <x-text-input wire:model="form.tags" id="tags" name="tags" type="text" class="mt-1 block w-full" autocomplete="tags" placeholder="Tags"/>
        @error('form.tags')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="category_id" :value="__('Category Id')"/>
        <x-text-input wire:model="form.category_id" id="category_id" name="category_id" type="text" class="mt-1 block w-full" autocomplete="category_id" placeholder="Category Id"/>
        @error('form.category_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="published_at" :value="__('Published At')"/>
        <x-text-input wire:model="form.published_at" id="published_at" name="published_at" type="text" class="mt-1 block w-full" autocomplete="published_at" placeholder="Published At"/>
        @error('form.published_at')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="is_published" :value="__('Is Published')"/>
        <x-text-input wire:model="form.is_published" id="is_published" name="is_published" type="text" class="mt-1 block w-full" autocomplete="is_published" placeholder="Is Published"/>
        @error('form.is_published')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="is_draft" :value="__('Is Draft')"/>
        <x-text-input wire:model="form.is_draft" id="is_draft" name="is_draft" type="text" class="mt-1 block w-full" autocomplete="is_draft" placeholder="Is Draft"/>
        @error('form.is_draft')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="views_count" :value="__('Views Count')"/>
        <x-text-input wire:model="form.views_count" id="views_count" name="views_count" type="text" class="mt-1 block w-full" autocomplete="views_count" placeholder="Views Count"/>
        @error('form.views_count')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="likes_count" :value="__('Likes Count')"/>
        <x-text-input wire:model="form.likes_count" id="likes_count" name="likes_count" type="text" class="mt-1 block w-full" autocomplete="likes_count" placeholder="Likes Count"/>
        @error('form.likes_count')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="comments_count" :value="__('Comments Count')"/>
        <x-text-input wire:model="form.comments_count" id="comments_count" name="comments_count" type="text" class="mt-1 block w-full" autocomplete="comments_count" placeholder="Comments Count"/>
        @error('form.comments_count')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="featured_image" :value="__('Featured Image')"/>
        <x-text-input wire:model="form.featured_image" id="featured_image" name="featured_image" type="text" class="mt-1 block w-full" autocomplete="featured_image" placeholder="Featured Image"/>
        @error('form.featured_image')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="media" :value="__('Media')"/>
        <x-text-input wire:model="form.media" id="media" name="media" type="text" class="mt-1 block w-full" autocomplete="media" placeholder="Media"/>
        @error('form.media')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="seo_page_id" :value="__('Seo Page Id')"/>
        <x-text-input wire:model="form.seo_page_id" id="seo_page_id" name="seo_page_id" type="text" class="mt-1 block w-full" autocomplete="seo_page_id" placeholder="Seo Page Id"/>
        @error('form.seo_page_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>