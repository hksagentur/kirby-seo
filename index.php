<?php

Kirby::plugin('hksagentur/seo', [
    'blueprints' => require __DIR__ . '/config/blueprints.php',
    'snippets' => require __DIR__ . '/config/snippets.php',
    'translations' => require __DIR__ . '/config/translations.php',
]);
