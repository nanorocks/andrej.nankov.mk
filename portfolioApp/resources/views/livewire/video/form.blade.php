<div class="space-y-6">
    
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
        <x-input-label for="video_url" :value="__('Video Url')"/>
        <x-text-input wire:model="form.video_url" id="video_url" name="video_url" type="text" class="mt-1 block w-full" autocomplete="video_url" placeholder="Video Url"/>
        @error('form.video_url')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="thumbnail_url" :value="__('Thumbnail Url')"/>
        <x-text-input wire:model="form.thumbnail_url" id="thumbnail_url" name="thumbnail_url" type="text" class="mt-1 block w-full" autocomplete="thumbnail_url" placeholder="Thumbnail Url"/>
        @error('form.thumbnail_url')
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
        <x-input-label for="is_published" :value="__('Is Published')"/>
        <x-text-input wire:model="form.is_published" id="is_published" name="is_published" type="text" class="mt-1 block w-full" autocomplete="is_published" placeholder="Is Published"/>
        @error('form.is_published')
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

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>