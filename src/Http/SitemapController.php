<?php

namespace Hks\Seo\Http;

use Kirby\Cms\App;
use Kirby\Http\Response;

class SitemapController
{
    public function __invoke(): Response|false
    {
        $kirby = App::instance();

        $cache = $kirby->cache('hksagentur.seo');
        $options = $kirby->option('hksagentur.seo.sitemap');

        $active = $options['active'] ?? false;

        if (! $active) {
            return false;
        }

        $xml = $cache->get('sitemap');

        if ($xml) {
            return new Response($xml, 'text/xml');
        }

        $items = $kirby->collection('sitemap');

        $xml = $kirby->snippet('seo/sitemap', [
            'items' => $items,
        ], true);

        $cache->set(
            key: 'sitemap',
            value: $xml,
            minutes: $options['cacheDuration'] ?? 60
        );

        return new Response($xml, 'text/xml');
    }
}
