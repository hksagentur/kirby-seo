<?php

use Kirby\Cms\Page;
use Kirby\Cms\Pages;
use Kirby\Cms\Site;

return [
    'sitemap' => function (Site $site): Pages {
        return $site->index()
            ->filter(fn (Page $page) => $page->inSitemap())
            ->sortBy(
                fn (Page $page) => $page->sitemapPriority(),
                SORT_DESC,
                SORT_NUMERIC,
            );
    },
];
