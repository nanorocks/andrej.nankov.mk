const CACHE_NAME = 'andrej-nankov-v6';

const PRECACHE_URLS = [
    '/',
    '/about',
    '/get-started',
    '/newsletter',
    '/shop',
    '/privacy',
    '/cookies',
    '/terms',
    '/refunds',
    '/shipping',
    '/offline',
    '/favicon.ico',
    '/android-chrome-192x192.png',
    '/android-chrome-512x512.png',
    '/assets/avatars/andrej-nankov-profile.png',
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

// Fetch strategy:
//   - Static assets (JS/CSS/images): cache-first
//   - HTML pages: network-first with offline fallback
//   - Private, transactional, API and admin routes: network-only
self.addEventListener('fetch', event => {
    const request = event.request;

    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    if (url.origin !== location.origin) {
        return;
    }

    const networkOnlyPaths = [
        '/admin',
        '/horizon',
        '/api',
        '/cart',
        '/checkout',
        '/profile',
        '/orders',
        '/downloads',
        '/login',
        '/register',
        '/paddle',
    ];

    // Let the browser handle cross-origin and private/transactional requests.
    if (
        url.origin !== location.origin ||
        event.request.method !== 'GET' ||
        networkOnlyPaths.some(path => url.pathname.startsWith(path))
    ) {
        return;
    }

    if (request.mode === 'navigate' || request.destination === 'document') {
        event.respondWith(
            fetch(request)
                .then(response => {
                    if (response.ok) {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
                    }

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
