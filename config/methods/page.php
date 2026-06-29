<?php

use Hks\Seo\Toolkit\Path;

return [
    'inSitemap' => function (): bool {
        $exclude = $this->content()->sitemapExclude()->toBool();

        if ($exclude) {
            return false;
        }

        $ignore = $this->kirby()->option('hksagentur.seo.sitemap.ignore');

        if (is_callable($ignore) && $ignore($this)) {
            return false;
        }

        if (is_array($ignore) && Path::match($this->id(), $ignore)) {
            return false;
        }

        return $this->isPublished() && !$this->isErrorPage();
    },
    'sitemapPriority' => function (): float {
        $priority = $this->content()->sitemapPriority()->toFloat(-1);

        if ($priority >= 0 && $priority <= 1) {
            return $priority;
        }

        if ($this->isHomePage()) {
            return 1.0;
        }

        return match ($this->depth()) {
            1 => 0.8,
            2 => 0.6,
            default => 0.5,
        };
    },
    'sitemapModified' => function (?string $format = null): ?string {
        $timestamp = $this->content()->sitemapModified()->toTimestamp() ?: $this->modified();

        if (! $timestamp) {
            return null;
        }

        return $format ? date($format, $timestamp) : $timestamp;
    },
];
