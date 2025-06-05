<?php

require __DIR__ . '/config/helpers.php';

Kirby::plugin('hksagentur/seo', [
    'blueprints' => require __DIR__ . '/config/blueprints.php',
    'snippets' => require __DIR__ . '/config/snippets.php',
    'translations' => require __DIR__ . '/config/translations.php',
    'collectionMethods' => require __DIR__ . '/config/methods/collection.php',
    'fieldMethods' => require __DIR__ . '/config/methods/field.php',
]);
