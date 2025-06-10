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
            ->or($this->defaultOgTitle());
    }

    public function ogDescription(): Field
    {
        return $this->content()
            ->ogDescription()
            ->replace()
            ->or($this->defaultOgDescription());
    }

    public function ogImage(): ?File
    {
        return $this->content()
            ->ogImage()
            ->toFile() ?? $this->defaultOgImage();
    }

    public function defaultOgTitle(): Field
    {
        return $this->metaTitle();
    }

    public function defaultOgDescription(): Field
    {
        return $this->metaDescription();
    }

    public function defaultOgImage(): ?File
    {
        return $this->site()
            ->content()
            ->ogImage()
            ->toFile();
    }
}
