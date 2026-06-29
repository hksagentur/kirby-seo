<?php

namespace Hks\Seo\Http;

use Kirby\Cms\App;
use Kirby\Http\Response;

class LlmsController
{
    public function __invoke(): Response|false
    {
        $kirby = App::instance();

        $cache = $kirby->cache('hksagentur.seo');
        $options = $kirby->option('hksagentur.seo.llms');

        $active = $options['active'] ?? false;

        if (! $active) {
            return false;
        }

        $markdown = $cache->get('llms');

        if ($markdown) {
            return new Response($markdown, 'text/plain');
        }

        $markdown = $kirby->snippet('seo/llms', data: [
            'kirby' => $kirby,
            'site' => $kirby->site(),
        ], return: true);

        $cache->set(
            key: 'llms',
            value: $markdown,
            minutes: $options['cacheDuration'] ?? 24 * 60
        );

        return new Response($markdown, 'text/plain');
    }
}
