<?php

namespace Hks\Seo\Cms;

use Closure;
use Kirby\Cms\Page;
use Kirby\Content\Field;

/**
 * @mixin Page
 */
trait HasMetaTags
{
    /**
     * @return array<string, mixed>
     */
    public function metaDefaults(?string $languageCode = null): array
    {
        return [];
    }

    public function metaDefault(string $key, ?Closure $fallback = null, ?string $languageCode = null): MetaValue
    {
        return MetaCascade::for($this, $languageCode)->get($key, $fallback);
    }

    public function metaTitle(?string $languageCode = null): Field
    {
        return $this->content($languageCode)
            ->metaTitle()
            ->replace()
            ->or($this->defaultMetaTitle($languageCode));
    }

    public function metaDescription(?string $languageCode = null): Field
    {
        return $this->content($languageCode)
            ->metaDescription()
            ->replace()
            ->or($this->defaultMetaDescription($languageCode));
    }

    public function defaultMetaTitle(?string $languageCode = null): Field
    {
        return new Field(
            parent: $this,
            key: 'metaTitle',
            value: $this->metaDefault(
                key: 'metaTitle',
                languageCode: $languageCode,
            )->toString(),
        );
    }

    public function defaultMetaDescription(?string $languageCode = null): Field
    {
        return new Field(
            parent: $this,
            key: 'metaDescription',
            value: $this->metaDefault(
                key: 'metaDescription',
                languageCode: $languageCode,
            )->toExcerpt(),
        );
    }
}
