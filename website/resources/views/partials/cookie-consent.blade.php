@php($analyticsId = app()->isProduction() ? config('services.google_analytics.id') : null)

<div id="cookie-consent" class="fixed inset-x-4 bottom-4 z-50 mx-auto hidden max-w-3xl rounded-2xl border border-white/15 bg-[#12151a] p-5 shadow-2xl shadow-black/60 sm:p-6" role="dialog" aria-modal="false" aria-labelledby="cookie-consent-title">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div class="max-w-xl">
            <h2 id="cookie-consent-title" class="text-lg font-bold text-white">Your cookie choice</h2>
            <p class="mt-2 text-sm leading-6 text-slate-300">Essential storage keeps accounts, carts, and checkout working. With your permission, optional analytics helps improve this website. <a href="{{ route('legal.cookies') }}" class="public-text-link">Read the Cookie Policy</a>.</p>
        </div>
        <div class="flex shrink-0 flex-wrap gap-3">
            <button type="button" data-cookie-essential class="public-button-secondary">Essential only</button>
            <button type="button" data-cookie-analytics class="public-nav-cta">Allow analytics</button>
        </div>
    </div>
</div>

<script>
    (() => {
        const storageKey = 'andrej_cookie_consent_v1';
        const analyticsId = @js($analyticsId);
        const panel = document.getElementById('cookie-consent');

        const loadAnalytics = () => {
            if (!analyticsId || document.querySelector('script[data-google-analytics]')) return;

            const script = document.createElement('script');
            script.async = true;
            script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(analyticsId)}`;
            script.dataset.googleAnalytics = 'true';
            document.head.appendChild(script);

            window.dataLayer = window.dataLayer || [];
            window.gtag = function () { window.dataLayer.push(arguments); };
            window.gtag('js', new Date());
            window.gtag('config', analyticsId, { anonymize_ip: true });
        };

        const choose = (preference) => {
            localStorage.setItem(storageKey, preference);
            panel.classList.add('hidden');
            if (preference === 'analytics') loadAnalytics();
        };

        const preference = localStorage.getItem(storageKey);
        if (preference === 'analytics') loadAnalytics();
        if (!preference) panel.classList.remove('hidden');

        document.querySelectorAll('[data-cookie-settings]').forEach((button) => {
            button.addEventListener('click', () => panel.classList.remove('hidden'));
        });
        panel.querySelector('[data-cookie-essential]').addEventListener('click', () => choose('essential'));
        panel.querySelector('[data-cookie-analytics]').addEventListener('click', () => choose('analytics'));
    })();
</script>
