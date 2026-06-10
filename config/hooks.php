<?php

use Kirby\Cms\App;
use Kirby\Cms\Event;

return [
    'page.*:after' => function (Event $event) {
        $actions = ['update', 'create', 'delete', 'changeStatus', 'changeSlug'];

        if (! in_array($event->action(), $actions, strict: true)) {
            return;
        }

        App::instance()->cache('hksagentur.seo')->remove('sitemap');
    },
];
