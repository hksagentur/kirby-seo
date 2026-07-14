<?php

namespace Hks\Seo\Cms;

use Kirby\Cms\Page;
use Kirby\Content\Field;

/**
 * @mixin Page
 */
trait HasRobotsTag
{
    public function canBeIndexedByBots(): bool
    {
        return $this->robotsIndexRule() !== 'noindex';
    }

    public function canBeFollowedByBots(): bool
    {
        return $this->robotsFollowRule() !== 'nofollow';
    }

    public function robots(): Field
    {
        return new Field(
            parent: $this,
            key: 'robots',
            value: implode(',', array_filter([
                $this->robotsIndexRule(),
                $this->robotsFollowRule(),
            ]))
        );
    }

    public function canonical(): Field
    {
        return new Field(
            parent: $this,
            key: 'canonical',
            value: $this->canBeIndexedByBots() ? $this->canonicalUrl() : null
        );
    }

    public function canonicalUrl(): string
    {
        $variable = $this->paginationVariable();
        $page = $this->paginationPage();

        if (! $this->isPaginated()) {
            return $this->url();
        }

        return match ($this->paginationMethod()) {
            'query' => $this->url(['query' => [$variable => $page]]),
            'param' => $this->url(['params' => [$variable => $page]]),
        };
    }

    protected function isPaginated(): bool
    {
        return $this->paginationPage() > 1;
    }

    protected function paginationMethod(): string
    {
        return $this->kirby()->option('pagination.method', 'param');
    }

    protected function paginationVariable(): string
    {
        return $this->kirby()->option('pagination.variable', 'page');
    }

    protected function paginationPage(): int
    {
        $variable = $this->paginationVariable();

        $page = match ($this->paginationMethod()) {
            'query' => $this->kirby()->request()->query()->get($variable),
            'param' => $this->kirby()->request()->params()->get($variable),
            default => null,
        };

        return $page !== null ? (int) $page : 1;
    }

    protected function robotsIndexRule(): string
    {
        $value = $this->content()->robotsIndex()->value();

        if ($value === '' && $this->isPaginated()) {
            return 'noindex';
        }

        return $value;
    }

    protected function robotsFollowRule(): string
    {
        $value = $this->content()->robotsFollow()->value();

        if ($value === '' && $this->isPaginated()) {
            return 'follow';
        }

        return $value;
    }
}
