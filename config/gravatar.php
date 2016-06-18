<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

return [
    // --- The default avatar size
    'size' => 80,

    // --- The default avatar to display if we have no results
    // (bool)   false
    // (string) 404
    // (string) mm: (mystery-man) a simple, cartoon-style silhouetted outline of a person (does not vary by email hash).
    // (string) identicon: a geometric pattern based on an email hash.
    // (string) monsterid: a generated 'monster' with different colors, faces, etc.
    // (string) wavatar: generated faces with differing features and backgrounds.
    // (string) retro: awesome generated, 8-bit arcade-style pixelated faces.
    'default' => 'identicon',

    // --- Set the type of avatars we allow to show
    // - g: suitable for display on all websites with any audience type.
    // - pg: may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
    // - r: may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
    // - x: may contain hardcore sexual imagery or extremely disturbing violence.
    'maxRating' => 'g',
];
