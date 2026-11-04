<?php

namespace Hks\Seo\Cms;

use Closure;
use Kirby\Cms\Page;
use Kirby\Toolkit\Controller;

readonly class MetaCascade
{
    public function __construct(
        protected Page $page,
        protected ?string $languageCode = null,
    ) {
    }

    public static function for(Page $page, ?string $languageCode = null): static
    {
        return new static($page, $languageCode);
    }

    public function get(string $key, ?Closure $fallback = null): MetaValue
    {
        $sources = [
            fn () => $this->modelDefault($key),
            $fallback,
            fn () => $this->pluginDefault($key),
        ];

        foreach (array_filter($sources) as $source) {
            $value = $this->unwrap($source);
            $value = new MetaValue($this->unwrap($value));

            if ($value->isNotEmpty()) {
                return $value;
            }
        }

        return new MetaValue();
    }

    protected function pluginDefault(string $key): mixed
    {
        return $this->page->kirby()->option("hksagentur.seo.meta.{$key}");
    }

    protected function modelDefault(string $key): mixed
    {
        if (! method_exists($this->page, 'metaDefaults')) {
            return null;
        }

        $defaults = $this->page->metaDefaults($this->languageCode);

        if (empty($defaults)) {
            return null;
        }

        return $defaults[$key] ?? null;
    }

    protected function unwrap(mixed $value): mixed
    {
        if (! ($value instanceof Closure)) {
            return $value;
        }

        return (new Controller($value))->call(data: [
            'kirby' => $this->page->kirby(),
            'site' => $this->page->site(),
            'page' => $this->page,
            'languageCode' => $this->languageCode,
        ]);
    }
}
