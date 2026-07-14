<?php

/**
 * @var \vakata\views\View $this
 * @var ?string $type
 * @var ?string $path
 * @var ?string $title
 * @var ?string $clss
 * @var string $cspNonce
 * @var ?string $image
 * @var ?array<string,string> $meta
 * @var \vakata\http\Uri $url
 * @var callable (string, array<string,string>=, bool=): string $asset
 * @var \vakata\intl\Intl $intl
 */
?>
<!DOCTYPE html>
<html lang="<?= $this->e($intl('_locale.code.short')) ?>" class="h-100">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $this->e(($title ?? 'Title') . ' НИФ') ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta property="og:locale" content="<?= $this->e($intl('_locale.code.long')) ?>" />
        <meta property="og:type" content="<?= $this->e($meta['og:type'] ?? $type ?? 'website') ?>" />
        <meta property="og:title"
        content="<?= $this->e($meta['og:title'] ?? ($title . ' НИФ')) ?>"/>
        <meta property="og:url"
        content="<?= $this->e($meta['og:url'] ?? "https://nif-public.dev.uslugi.io/") ?>" />
        <meta property="og:image"
            content="<?= $this->e($meta['og:image'] ?? $asset('assets/og-image.jpg', [], true)) ?>" />
        <link rel="apple-touch-icon" sizes="180x180" 
                href="<?= $this->e($meta['apple-touch-icon'] ?? $asset('assets/apple-touch-icon.png', [], true)) ?>">
        <meta name="title"
        content="<?= $this->e($meta['title'] ?? $title . ' НИФ') ?>" />
        <meta name="author" content="Информационно обслужване" />
        <meta name="robots" content="index, follow" />
        <meta name="description"
        content="Официален сайт на Националния иновационен фонд – информация за програми и финансиране, 
        иновационни проекти, партньорства, документи, новини, събития и постигнати резултати." />
        <meta name="keywords" content="Национален иновационен фонд, НИФ, National Innovation Fund, NIF, иновации, 
        финансиране на иновации, програми за финансиране, научноизследователска дейност, развойна дейност, иновационни 
        проекти, български предприятия, МСП, високи технологии, изкуствен интелект, дигитализация, зелени технологии, 
        устойчиво индустриално развитие, Eurostars, Eureka, проекти и резултати, партньорства, документи, новини и 
        събития" />
        <meta name="application-name" content="Национален иновационен фонд" />
        <link rel="canonical" href="https://nif-public.dev.uslugi.io/" />
        <meta property="og:site_name" content="Национален иновационен фонд" />
        <meta property="og:description"
            content="Официален сайт на Националния иновационен фонд с информация за програми и 
        финансиране, проекти, резултати, партньорства, документи и новини." />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:domain" content="nif-public.dev.uslugi.io" />
        <meta name="twitter:image"
            content="<?= $this->e($meta['og:image'] ?? $asset('assets/og-image.jpg', [], true)) ?>">
        <meta name="twitter:title"
            content="<?= $this->e($meta['twitter:title'] ?? ($title . ' НИФ')) ?>" />
        <meta name="twitter:description"
            content="Официален сайт на Националния иновационен фонд с информация за програми, финансиране, проекти, 
            резултати, документи и новини." />
        <meta name="twitter:url" content="https://nif-public.dev.uslugi.io/" />
        <link rel="icon" type="image/png" sizes="96x96"
            href="<?= $this->e($meta['favicon_svg'] ?? $asset('favicon.svg', [], true)) ?>">
        <link rel="icon" type="image/png" sizes="192x192"
            href="<?= $this->e($meta['favicon_png'] ?? $asset('web-app192x192.png', [], true)) ?>">
        <link rel="icon" type="image/png" sizes="512x512"
            href="<?= $this->e($meta['favicon_png'] ?? $asset('web-app512x512.png', [], true)) ?>">
        <link rel="manifest" href="<?= $this->e($meta['manifest'] ?? $asset('mix-manifest', [], true)) ?>">
        <link rel="stylesheet" href="<?= $this->e($asset('assets/accessibility/accessibility.css')) ?>">
        <link rel="stylesheet" href="<?= $this->e($asset('assets/css/flatpickr.css')) ?>" />
        <link rel="stylesheet" href="<?= $this->e($asset('assets/css/main.css')) ?>" />
        <?= $this->section('head'); ?>
        <!-- Matomo -->
        <script nonce="<?= $cspNonce ?>">
            var _paq = window._paq = window._paq || [];
            /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u="//track.uslugi.io/";
                _paq.push(['setTrackerUrl', u+'matomo.php']);
                _paq.push(['setSiteId', '68']);
                var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
            })();
        </script>
        <!-- End Matomo Code -->
    </head>

    <body class="d-flex flex-column h-100 <?= $this->e($clss ?? '') ?>">
        <?= $this->section('content'); ?>
        <script src="<?= $this->e($asset('assets/scripts/swiper.js')); ?>"></script>
        <script src="<?= $this->e($asset('assets/scripts/lightgallery.js')); ?>"></script>
        <script src="<?= $this->e($asset('assets/accessibility/accessibility.js')); ?>"></script>
        <script src="<?= $this->e($asset('assets/scripts/accessibility.js')); ?>"></script> 
        <script src="<?= $this->e($asset('assets/scripts/main.js')); ?>"></script>
    </body>
</html>