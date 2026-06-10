<?php

use Hks\Seo\Http\RobotsController;
use Hks\Seo\Http\SitemapController;
use Kirby\Cms\App;
use Kirby\Http\Response;

return fn (App $kirby) => [
    [
        'pattern' => 'robots.txt',
        'method' => 'GET',
        'action' => function () use ($kirby) : Response|false {
            /** @var callable $controller */
            $controller = $kirby->apply('seo.robots:before', [
                'controller' => new RobotsController(),
            ], 'controller');

            $response = $controller();

            $response = $kirby->apply('seo.robots:after', [
                'response' => $response,
            ], 'response');

            return $response;
        },
    ],
    [
        'pattern' => $kirby->option('hksagentur.seo.sitemap.path', 'sitemap.xml'),
        'method' => 'GET',
        'action' => function () use ($kirby) : Response|false {
            /** @var callable $controller */
            $controller = $kirby->apply('seo.sitemap:before', [
                'controller' => new SitemapController(),
            ], 'controller');

            $response = $controller();

            $response = $kirby->apply('seo.sitemap:after', [
                'response' => $response,
            ], 'response');

            return $response;
        }
    ],
];
