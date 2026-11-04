<?php

namespace Hks\Seo\Toolkit;

use Kirby\Toolkit\Html as BaseHtml;
use Kirby\Toolkit\Str;

class Html extends BaseHtml
{
    /**
     * Runs of spaces, tabs and line breaks, but not non-breaking spaces.
     */
    public const WHITESPACE = '![ \t\r\n]+!';

    /**
     * Closing block tags and line breaks that separate words in plain text.
     */
    public const BLOCK_BOUNDARY = '!(</(?:p|h[1-6]|li|dt|dd|blockquote|figcaption|td|th|div)>|<br\s*/?>)!i';

    /**
     * Text of an HTML string, without tags or entities.
     */
    public static function plainText(string $markup): string
    {
        $markup = preg_replace(pattern: static::BLOCK_BOUNDARY, replacement: '$1 ', subject: $markup);
        $markup = Str::unhtml(string: $markup);
        $markup = preg_replace(pattern: static::WHITESPACE, replacement: ' ', subject: $markup);
        $markup = trim(string: $markup);

        return $markup;
    }
}
