<?php

namespace Hks\Seo\Llms;

use Kirby\Cms\Item;
use Kirby\Cms\Page;
use Kirby\Cms\Pages;
use Kirby\Cms\Site;

/**
 * @method Site parent()
 */
class Section extends Item
{
    public const ITEMS_CLASS = Sections::class;

    protected ?string $title;
    protected Pages $pages;

    public function __construct(array $params = [])
    {
        parent::__construct($params);

        $this->title = $params['title'] ?? null;
        $this->pages = $this->resolvePages($params['items'] ?? []);
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function pages(): Pages
    {
        return $this->pages;
    }

    /**
     * @return array{title: ?string, items: list<string>}
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'items' => $this->pages->pluck('id'),
        ];
    }

    /**
     * @param iterable<Page|string> $items
     */
    protected function resolvePages(iterable $items): Pages
    {
        $ids = [];

        foreach ($items as $item) {
            $ids[] = match (true) {
                $item instanceof Page => $item->id(),
                default => $item,
            };
        }

        return $this->parent()->find(false, false, ...$ids);
    }
}
