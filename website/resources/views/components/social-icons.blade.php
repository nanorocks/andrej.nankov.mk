<div class="flex gap-4 mt-4 justify-center">
    @foreach($links as $link)
        <a target="_blank" href="{{ $link->url }}"
           class="btn btn-circle btn-outline btn-sm hover:text-white text-gray-400 border-gray-400 hover:border-white"
           title="{{ $link->name }}">
            <i data-feather="{{ $link->icon }}" class="w-5 h-5"></i>
        </a>
    @endforeach
</div>
