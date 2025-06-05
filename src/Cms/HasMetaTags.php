<?php

namespace Hks\Seo\Cms;

use Kirby\Content\Field;

trait HasMetaTags
{
    public function metaTitle(): Field
    {
        return $this->content()
            ->metaTitle()
            ->replace()
            ->or($this->defaultMetaTitle());
    }

    public function metaDescription(): Field
    {
        return $this->content()
            ->metaDescription()
            ->replace()
            ->or($this->defaultMetaDescription());
    }

    public function defaultMetaTitle(): Field
    {
        return new Field(
            parent: $this,
            key: 'metaTitle',
            value: $this->title()->value(),
        );
    }

    public function defaultMetaDescription(): Field
    {
        return new Field(
            parent: $this,
            key: 'metaDescription',
            value: match (true) {
                $this->content()->blocks()->exists() => $this->content()->blocks()->toBlocks()->excerpt(160),
                $this->content()->text()->exists() => $this->content()->text()->excerpt(160),
                default => null,
            }
        );
    }
}
