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

/**
 * Wrapper of the BlurHash algorithm as a Symfony service (@see https://blurha.sh).
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @experimental
 */
interface BlurHashInterface
{
    /**
     * Create and return a blurred thumbnail of the given image encoded as data URI using the BlurHash algorithm.
     *
     * @param string $filename       The filename of the original image
     * @param int    $width          The width of the thumbnail to create
     * @param int    $height         The height of the thumbnail to create
     * @param int    $encodingWidth  The internal width that should be used to create the blurred version of the image.
     *                               Reducing this value will decrease generation time but also decrease the blurring precision.
     * @param int    $encodingHeight The internal width that should be used to create the blurred version of the image.
     *                               Reducing this value will decrease generation time but also decrease the blurring precision.
     *
     * @return string the data: image/jpeg base64 encoded image content usable in an image HTML tag
     */
    public function createDataUriThumbnail(string $filename, int $width, int $height, int $encodingWidth = 75, int $encodingHeight = 75): string;

    /**
     * Encode the given image using the BlurHash algorithm.
     *
     * @param string $filename       The filename of the original image
     * @param int    $encodingWidth  The internal width that should be used to create the blurred version of the image.
     *                               Reducing this value will decrease generation time but also decrease the blurring precision.
     * @param int    $encodingHeight The internal width that should be used to create the blurred version of the image.
     *                               Reducing this value will decrease generation time but also decrease the blurring precision.
     *
     * @return string the BlurHash of the image
     */
    public function encode(string $filename, int $encodingWidth = 75, int $encodingHeight = 75): string;
}
