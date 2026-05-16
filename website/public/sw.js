const CACHE_NAME = 'andrej-nankov-v1';

const PRECACHE_URLS = [
    '/',
    '/about',
    '/get-started',
    '/newsletter',
    '/offline',
    '/manifest.json',
    '/favicon.ico',
    '/android-chrome-192x192.png',
    '/android-chrome-512x512.png',
];

// Install — pre-cache shell pages and assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(PRECACHE_URLS))
            .then(() => self.skipWaiting())
    );
});

// Activate — clear old caches
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
//   - API / admin routes: network-only
self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // Skip cross-origin requests and admin/horizon/api routes
    if (
        url.origin !== location.origin ||
        url.pathname.startsWith('/admin') ||
        url.pathname.startsWith('/horizon') ||
        url.pathname.startsWith('/api')
    ) {
        return;
    }

    const isStaticAsset = /\.(js|css|png|jpg|jpeg|gif|svg|ico|woff2?|ttf)$/i.test(url.pathname);

    if (isStaticAsset) {
        // Cache-first for static assets
        event.respondWith(
            caches.match(event.request).then(cached =>
                cached || fetch(event.request).then(response => {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
                    return response;
                })
            )
        );
        return;
    }

    // Network-first for HTML pages
    event.respondWith(
        fetch(event.request)
            .then(response => {
                const clone = response.clone();
                caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
                return response;
            })
            .catch(() =>
                caches.match(event.request).then(cached =>
                    cached || caches.match('/offline')
                )
            )
    );
});
