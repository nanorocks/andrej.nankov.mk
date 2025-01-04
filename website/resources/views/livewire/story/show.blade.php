<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $story->name ?? __('Show') . ' ' . __('Story') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-ba font-semibold leading-6 text-base-900 text-2xl flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-book-open mr-1">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                            {{ __('Show') }} Story
                        </h1>
                        <p class="mt-2 text-sm text-base-700">Details of {{ __('Story') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('stories.index') }}"
                            class="btn btn-secondary text-base">Back</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="mt-6 border-t border-base-100">
                                <dl class="divide-y divide-base-100">
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Slug</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->slug }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Title</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->title }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Content</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->content }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Excerpt</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->excerpt }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Author Id</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->author_id }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Tags</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->tags }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Category Id</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->category_id }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Published At</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->published_at }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Is Published</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->is_published }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Is Draft</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->is_draft }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Views Count</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->views_count }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Likes Count</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->likes_count }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Comments Count</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->comments_count }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Featured Image</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->featured_image }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Media</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->media }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Seo Page Id</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $story->seo_page_id }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
