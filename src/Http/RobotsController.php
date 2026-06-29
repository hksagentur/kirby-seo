<?php

namespace Hks\Seo\Http;

use Kirby\Cms\App;
use Kirby\Http\Response;

class RobotsController
{
    public function __invoke(): Response|false
    {
        $kirby = App::instance();

        $cache = $kirby->cache('hksagentur.seo');
        $options = $kirby->option('hksagentur.seo');

        $robots = $options['robots']['active'] ?? false;
        $sitemap = $options['sitemap']['active'] ?? false;

        if (! $robots) {
            return false;
        }

        $text = $cache->get('robots');

        if ($text) {
            return new Response($text, 'text/plain');
        }

        $path = $sitemap
            ? $options['sitemap']['path'] ?? 'sitemap.xml'
            : null;

        $disallow = $options['robots']['disallow'] ?? [];

        $text = $kirby->snippet('seo/robots', data: [
            'kirby' => $kirby,
            'site' => $kirby->site(),
            'disallow' => $disallow,
            'sitemap' => $path,
        ], return: true);

        $cache->set(
            key: 'robots',
            value: $text,
            minutes: $options['robots']['cacheDuration'] ?? 24 * 60
        );

        return new Response($text, 'text/plain');
    }
}
