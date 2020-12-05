<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\LazyImage\BlurHash;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * Cached decorator for BlurHash implementations.
 *
 * @final
 * @experimental
 */
class CachedBlurHash implements BlurHashInterface
{
    private $blurHash;
    private $cache;
    private $defaultExpiresAfter;

    /**
     * @param BlurHashInterface $blurHash            Underlying implmentation of BlurHashInterface
     * @param CacheInterface    $cache               Cache storage to use
     * @param int|null          $defaultExpiresAfter Default expiration time of the BlurHash results, or null to never expire
     */
    public function __construct(BlurHashInterface $blurHash, CacheInterface $cache, int $defaultExpiresAfter = null)
    {
        $this->blurHash = $blurHash;
        $this->cache = $cache;
        $this->defaultExpiresAfter = $defaultExpiresAfter;
    }

    public function createDataUriThumbnail(string $filename, int $width, int $height, int $encodingWidth = 75, int $encodingHeight = 75): string
    {
        return $this->blurHash->createDataUriThumbnail($filename, $width, $height, $encodingWidth, $encodingHeight);
    }

    public function encode(string $filename, int $encodingWidth = 75, int $encodingHeight = 75): string
    {
        $key = json_encode([$filename, $encodingWidth, $encodingHeight]);

        return $this->cache->get($key, [$this, 'doEncode']);
    }

    /**
     * @internal
     */
    public function doEncode(ItemInterface $item): string
    {
        if (null !== $this->defaultExpiresAfter) {
            $item->expiresAfter($this->defaultExpiresAfter);
        }

        $params = json_decode($item->getKey(), true);

        return $this->blurHash->createDataUriThumbnail($params[0], $params[1], $params[2]);
    }
}
