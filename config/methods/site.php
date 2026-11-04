<?php

use Hks\Seo\Llms\Sections;
use Kirby\Cms\File;
use Kirby\Content\Field;

return [
    'ogSiteName' => function (?string $languageCode = null): Field {
        return $this->content($languageCode)
            ->ogSiteName()
            ->or($this->content($languageCode)->title());
    },
    'ogImage' => function (?string $languageCode = null): ?File {
        return $this->content($languageCode)
            ->ogImage()
            ->toFile();
    },
    'llmsTitle' => function (?string $languageCode = null): Field {
        return $this->content($languageCode)
            ->llmsTitle()
            ->or($this->content($languageCode)->title());
    },
    'llmsDescription' => function (?string $languageCode = null): Field {
        return $this->content($languageCode)
            ->llmsDescription()
            ->or($this->content($languageCode)->metaDescription());
    },
    'llmsSections' => function (?string $languageCode = null): Sections {
        return Sections::for($this, $languageCode);
    },
];
