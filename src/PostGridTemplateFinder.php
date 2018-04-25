<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use RuntimeException;
use function App\sage;

class PostGridTemplateFinder
{
    private const NOT_FOUND = 'not found';

    public static function templatePath(string $prefix, string $postType): string
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        $dir = untrailingslashit(
            $helper->getPostGridTemplateDir()
        );

        $paths = [
            "$dir/$prefix-$postType.blade.php",
            "$dir/$prefix-$postType.php",
            "$dir/$prefix.blade.php",
            "$dir/$prefix.php",
            __DIR__ . "/../post-grid/$prefix-$postType.blade.php",
            __DIR__ . "/../post-grid/$prefix-$postType.php",
            __DIR__ . "/../post-grid/$prefix.blade.php",
            __DIR__ . "/../post-grid/$prefix.php",
        ];

        $path = array_first($paths, function (string $path): bool {
            return file_exists($path);
        }, self::NOT_FOUND);

        if (self::NOT_FOUND === $path) {
            throw new RuntimeException('Template not found in ' . implode(', ', $paths));
        }

        if (ends_with($path, '.blade.php')) {
            /** @var AbstractHelper $helper */
            $helper = sage(AbstractHelper::class);
            $path = $helper->templatePath($path);
        }

        return $path;
    }
}
