<?php

namespace Hks\Seo\Cms;

use Hks\Seo\Toolkit\Html;
use Kirby\Cms\Blocks;
use Kirby\Cms\File;
use Kirby\Content\Field;
use Kirby\Toolkit\Str;

readonly class MetaValue
{
    public function __construct(
        protected mixed $value = null,
    ) {
    }

    public function isEmpty(): bool
    {
        return match (true) {
            $this->value instanceof Field => $this->value->isEmpty(),
            $this->value instanceof Blocks => $this->value->isEmpty(),
            is_string($this->value) => trim($this->value) === '',
            default => $this->value === null,
        };
    }

    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    public function toString(): ?string
    {
        $string = match (true) {
            $this->value instanceof Field => $this->value->value(),
            is_string($this->value) => $this->value,
            default => null,
        };

        return $string ?: null;
    }

    public function toHtml(): ?string
    {
        $markup = match (true) {
            $this->value instanceof Blocks => $this->value->toHtml(),
            $this->value instanceof Field => $this->value->kirbytext()->value(),
            is_string($this->value) => Html::encode($this->value),
            default => null,
        };

        return $markup ?: null;
    }

    public function toPlainText(): ?string
    {
        $markup = $this->toHtml();

        if (! $markup) {
            return null;
        }

        return Html::plainText($markup) ?: null;
    }

    public function toExcerpt(int $length = 160): ?string
    {
        $text = $this->toPlainText();

        if (! $text) {
            return null;
        }

        return Str::excerpt($text, $length, strip: false);
    }

    public function toFile(): ?File
    {
        return match (true) {
            $this->value instanceof File => $this->value,
            $this->value instanceof Field => $this->value->toFile(),
            default => null,
        };
    }
}
