const CACHE_NAME = 'andrej-nankov-v2';

const PRECACHE_URLS = [
    '/',
    '/about',
    '/get-started',
    '/newsletter',
    '/offline',
    '/favicon.ico',
    '/android-chrome-192x192.png',
    '/android-chrome-512x512.png',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => Promise.all(
                PRECACHE_URLS.map(url =>
                    cache.add(url).catch(() => null)
                )
            ))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
            )
        ).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    const request = event.request;

    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    if (url.origin !== location.origin) {
        return;
    }

    if (
        url.pathname.startsWith('/admin') ||
        url.pathname.startsWith('/horizon') ||
        url.pathname.startsWith('/api') ||
        url.pathname.startsWith('/livewire') ||
        url.pathname.startsWith('/filament') ||
        url.pathname.startsWith('/vendor/') ||
        url.pathname.startsWith('/storage/') ||
        url.pathname === '/events' ||
        url.pathname === '/manifest.json' ||
        url.pathname === '/sw.js'
    ) {
        return;
    }

    if (request.mode === 'navigate' || request.destination === 'document') {
        event.respondWith(
            fetch(request)
                .then(response => {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
                    return response;
                })
                .catch(() =>
                    caches.match(request).then(cached => cached || caches.match('/offline'))
                )
        );
        return;
    }

    const isStaticAsset = /\.(png|jpg|jpeg|gif|svg|ico|woff2?|ttf)$/i.test(url.pathname);

    if (isStaticAsset) {
        event.respondWith(
            caches.match(request).then(cached =>
                cached || fetch(request).then(response => {
                    if (response.ok) {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
                    }
                    return response;
                }).catch(() => cached)
            )
        );
    }
});
