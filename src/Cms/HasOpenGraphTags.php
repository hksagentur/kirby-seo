<?php

namespace Hks\Seo\Cms;

use Kirby\Cms\File;
use Kirby\Cms\Page;
use Kirby\Content\Field;

/**
 * @mixin Page
 */
trait HasOpenGraphTags
{
    use HasMetaTags;

    public function ogTitle(?string $languageCode = null): Field
    {
        return $this->content($languageCode)
            ->ogTitle()
            ->replace()
            ->or($this->defaultOgTitle($languageCode));
    }

    public function ogDescription(?string $languageCode = null): Field
    {
        return $this->content($languageCode)
            ->ogDescription()
            ->replace()
            ->or($this->defaultOgDescription($languageCode));
    }

    public function ogImage(?string $languageCode = null): ?File
    {
        return $this->content($languageCode)
            ->ogImage()
            ->toFile() ?? $this->defaultOgImage($languageCode);
    }

    public function defaultOgTitle(?string $languageCode = null): Field
    {
        return new Field(
            parent: $this,
            key: 'ogTitle',
            value: $this->metaDefault(
                key: 'ogTitle',
                fallback: fn () => $this->metaTitle($languageCode)->value(),
                languageCode: $languageCode,
            )->toString(),
        );
    }

    public function defaultOgDescription(?string $languageCode = null): Field
    {
        return new Field(
            parent: $this,
            key: 'ogDescription',
            value: $this->metaDefault(
                key: 'ogDescription',
                fallback: fn () => $this->metaDescription($languageCode)->value(),
                languageCode: $languageCode,
            )->toPlainText(),
        );
    }

    public function defaultOgImage(?string $languageCode = null): ?File
    {
        return $this->metaDefault(
            key: 'ogImage',
            fallback: fn () => $this->site()->content($languageCode)->ogImage(),
            languageCode: $languageCode,
        )->toFile();
    }
}
