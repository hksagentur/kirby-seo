<?php

namespace Hks\Seo\Cms;

use Kirby\Cms\Page;

/**
 * @mixin Page
 */
trait HasSeoTags
{
    use HasMetaTags;
    use HasOpenGraphTags;
    use HasRobotsTag;
}
