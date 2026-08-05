<nav class="flex flex-wrap justify-center gap-2" aria-label="Social profiles">
    @foreach ($links as $link)
        <a
            target="_blank"
            rel="noopener noreferrer"
            href="{{ $link->url }}"
            data-pan="Soc-{{ $link->name }}"
            class="public-social-link"
            aria-label="Visit Andrej Nankov on {{ $link->name }}"
            title="{{ $link->name }}"
        >
            @switch($link->icon)
                @case('linkedin')
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 8.2H3.1V21h3.4V8.2ZM4.8 3A2 2 0 1 0 4.8 7a2 2 0 0 0 0-4ZM21 13.7c0-3.9-2.1-5.8-4.9-5.8a4.2 4.2 0 0 0-3.8 2.1V8.2H9V21h3.4v-6.3c0-1.7.3-3.3 2.4-3.3s2.7 1.9 2.7 3.4V21H21v-7.3Z"/></svg>
                    @break
                @case('youtube')
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23 7.1a3 3 0 0 0-2.1-2.2C19 4.4 12 4.4 12 4.4s-7 0-8.9.5A3 3 0 0 0 1 7.1 31 31 0 0 0 .5 12a31 31 0 0 0 .5 4.9 3 3 0 0 0 2.1 2.2c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.2 31 31 0 0 0 .5-4.9 31 31 0 0 0-.5-4.9ZM9.7 15.3V8.7l6 3.3-6 3.3Z"/></svg>
                    @break
                @case('book-open')
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.4 5.2a.8.8 0 0 0-.3-.7L.3 2.3V2h7l5.4 11.9L17.5 2H24v.3l-1.6 1.5a.5.5 0 0 0-.2.5v11.3a.5.5 0 0 0 .2.5l1.6 1.5v.3h-8v-.3l1.7-1.5c.2-.2.2-.3.2-.6V6.4L13 17.8h-.6L6.7 6.4V14c-.1.4 0 .9.4 1.2l2.1 2.5v.3H3v-.3l2.1-2.5c.3-.3.4-.8.4-1.2V5.2H2.4Z"/></svg>
                    @break
                @case('github')
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 .7A11.5 11.5 0 0 0 8.4 23c.6.1.8-.3.8-.6v-2.2c-3.4.7-4.1-1.4-4.1-1.4-.5-1.4-1.3-1.8-1.3-1.8-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1.1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.8-1.6-2.7-.3-5.5-1.3-5.5-5.7 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.6.1-3.2 0 0 1-.3 3.2 1.2a11 11 0 0 1 5.8 0C15.7 3.6 16.7 4.9 16.7 4.9c.6 1.6.2 2.9.1 3.2.8.8 1.2 1.8 1.2 3.1 0 4.4-2.8 5.4-5.5 5.7.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6A11.5 11.5 0 0 0 12 .7Z"/></svg>
                    @break
                @case('facebook')
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12A12 12 0 1 0 10.1 23.9v-8.4H7.1V12h3V9.4c0-3 1.8-4.6 4.5-4.6 1.3 0 2.6.2 2.6.2v2.9h-1.5c-1.5 0-1.9.9-1.9 1.8V12H17l-.5 3.5h-2.8v8.4A12 12 0 0 0 24 12Z"/></svg>
                    @break
                @default
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v17H6.5A2.5 2.5 0 0 0 4 21.5v-17Zm2.5 12.2H17V5H6.5A.5.5 0 0 0 6 5.5v11.3c.2-.1.3-.1.5-.1Z"/></svg>
            @endswitch
            <span class="sr-only">{{ $link->name }}</span>
        </a>
    @endforeach
</nav>
