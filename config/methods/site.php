<?php

use Kirby\Cms\Page;
use Kirby\Content\Field;
use Kirby\Data\Yaml;
use Kirby\Toolkit\Collection;
use Kirby\Cms\File;

return [
    'ogSiteName' => function (): Field {
        return $this->content()->ogSiteName()->or($this->content()->title());
    },
    'ogImage' => function (): ?File {
        return $this->content()->ogImage()->toFile();
    },
    'llmsTitle' => function (): Field {
        return $this->content()->llmsTitle()->or($this->content()->title());
    },
    'llmsDescription' => function (): Field {
        return $this->content()->llmsDescription()->or($this->content()->metaDescription());
    },
    'llmsSections' => function (): Field {
        $field = $this->content()->llmsSections();

        if ($field->exists()) {
            return $field;
        }

        $sections = $this->kirby()->option('hksagentur.seo.llms.sections') ?? [[
            'title' => 'Pages',
            'items' => $this->pages()->filter(fn (Page $page) => $page->inSitemap()),
        ]];

        if (is_callable($sections)) {
            $sections = $sections();
        }

        $toCollection = fn (Collection|array|null $collection) => match (true) {
            $collection instanceof Collection => $collection,
            is_array($collection) => new Collection($collection),
            default => new Collection(),
        };

        $toStructure = fn (array $sections) => match (true) {
            array_is_list($sections) => array_map(fn (array $section) => [
                'title' => $section['title'] ?? null,
                'items' => $toCollection($section['items'] ?? [])->pluck('id'),
            ], $sections),
            default => array_map(fn (Collection|array|null $items, string $key) => [
                'title' => $key,
                'items' => $toCollection($items ?? [])->pluck('id'),
            ], $sections, array_keys($sections)),
        };

        return new Field(
            parent: $this,
            key: 'llmsSections',
            value: Yaml::encode($toStructure($sections)),
        );
    },
];
