<?php

namespace Hks\Seo\Cms;

use Kirby\Cms\File;
use Kirby\Content\Field;

trait HasOpenGraphTags
{
    use HasMetaTags;

    public function ogSiteName(): Field
    {
        return $this->site()->title();
    }

    public function ogTitle(): Field
    {
        return $this->content()
            ->ogTitle()
            ->replace()
            ->or($this->metaTitle());
    }

    public function ogDescription(): Field
    {
        return $this->content()
            ->ogDescription()
            ->replace()
            ->or($this->metaDescription());
    }

    public function ogImage(): ?File
    {
        return $this->content()
            ->ogImage()
            ->or($this->site()->ogImage())
            ->toFile();
    }
}
