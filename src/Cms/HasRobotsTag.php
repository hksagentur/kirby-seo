<?php

namespace Hks\Seo\Cms;

use Kirby\Content\Field;

trait HasRobotsTag
{
    public function canBeIndexedByBots(): bool
    {
        return $this->content()->robotsFollow()->value() !== 'nofollow';
    }

    public function canBeFollowedByBots(): bool
    {
        return $this->content()->robotsFollow()->value() !== 'nofollow';
    }

    public function canonical(): Field
    {
        return new Field(
            parent: $this,
            key: 'canonical',
            value: $this->canBeIndexedByBots() ? $this->url() : null
        );
    }

    public function robots(): Field
    {
        $values = implode(',', array_filter([
            $this->content()->robotsIndex()->value(),
            $this->content()->robotsFollow()->value(),
        ]));

        return new Field(
            parent: $this,
            key: 'robots',
            value: $values ?: null
        );
    }
}
