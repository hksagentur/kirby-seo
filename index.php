<?php

Kirby::plugin('hksagentur/seo', [
    'options' => [
        'cache' => true,
        'robots' => [
            'active' => true,
            'disallow' => [],
            'cacheDuration' => 24 * 60,
        ],
        'sitemap' => [
            'active' => true,
            'ignore' => [],
            'cacheDuration' => 60,
        ],
    ],
    'blueprints' => require __DIR__ . '/config/blueprints.php',
    'collections' => require __DIR__ . '/config/collections.php',
    'hooks' => require __DIR__ . '/config/hooks.php',
    'routes' => require __DIR__ . '/config/routes.php',
    'snippets' => require __DIR__ . '/config/snippets.php',
    'translations' => require __DIR__ . '/config/translations.php',
    'pageMethods' => require __DIR__ . '/config/methods/page.php',
]);
