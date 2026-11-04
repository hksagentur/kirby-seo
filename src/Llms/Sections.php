<?php

namespace Hks\Seo\Llms;

use Closure;
use Kirby\Cms\Items;
use Kirby\Cms\Page;
use Kirby\Cms\Site;
use Kirby\Cms\Structure;
use Kirby\Cms\StructureObject;
use Kirby\Content\Field;
use Kirby\Toolkit\Collection;
use Kirby\Toolkit\Controller;

/**
 * @extends Items<Section>
 */
class Sections extends Items
{
    public const ITEM_CLASS = Section::class;

    public static function for(Site $site, ?string $languageCode = null): static
    {
        $field = $site->content($languageCode)->llmsSections();

        $sections = match (true) {
            $field->isNotEmpty() => static::fromField($field),
            default => static::fromOption($site, $languageCode),
        };

        return static::factory($sections, ['parent' => $site]);
    }

    public function toStructure(): Structure
    {
        return Structure::factory($this->toArray(), [
            'parent' => $this->parent(),
        ]);
    }

    /**
     * @return list<array{title: ?string, items: mixed}>
     */
    protected static function fromField(Field $field): array
    {
        return array_values($field->toStructure()->toArray(fn (StructureObject $row) => [
            'title' => $row->title()->value(),
            'items' => $row->items()->toPages(),
        ]));
    }

    /**
     * @return list<array{title: ?string, items: mixed}>
     */
    protected static function fromOption(Site $site, ?string $languageCode = null): array
    {
        $sections = $site->kirby()->option('hksagentur.seo.llms.sections') ?? [[
            'title' => 'Pages',
            'items' => $site->pages()->filter(fn (Page $page) => $page->inSitemap()),
        ]];

        if (is_callable($sections)) {
            $sections = (new Controller(Closure::fromCallable($sections)))->call(data: [
                'kirby' => $site->kirby(),
                'site' => $site,
                'languageCode' => $languageCode,
            ]);
        }

        if (array_is_list($sections)) {
            return array_map(fn (array $section) => [
                'title' => $section['title'] ?? null,
                'items' => $section['items'] ?? [],
            ], $sections);
        }

        return array_map(fn (Collection|array|null $items, string $title) => [
            'title' => $title,
            'items' => $items ?? [],
        ], $sections, array_keys($sections));
    }
}
