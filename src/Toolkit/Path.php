<?php

namespace Hks\Seo\Toolkit;

class Path
{
    /**
     * @var array<string, string>
     */
    protected static array $wildcards = [
        '(:all)' => '(.*)',
        '(:any)' => '([a-zA-Z0-9\.\-_%= \+\@\(\)]+)',
        '(:num)' => '(-?[0-9]+)',
        '(:alpha)' => '([a-zA-Z]+)',
        '(:alphanum)' => '([a-zA-Z0-9]+)',
    ];

    /**
     * @param string $path
     * @param array $patterns
     * @return bool
     */
    public static function match(string $path, array $patterns): bool
    {
        $path = ltrim($path, '/');

        foreach ($patterns as $pattern) {
            $pattern = ltrim($pattern, '/');

            if ($pattern === $path) {
                return true;
            }

            if (! str_contains($pattern, '(')) {
                continue;
            }

            $regex = strtr($pattern, self::$wildcards);

            if (preg_match('#^' . $regex . '$#u', $path)) {
                return true;
            }
        }

        return false;
    }
}
