<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Derives the whole favicon set from the single square image an editor
 * uploads, so nobody has to prepare a dozen files by hand.
 *
 * Output lands in storage/app/public/branding/<hash>/ — the hash is taken from
 * the source file, so re-saving the section without changing the image costs
 * nothing, and a new upload never overwrites icons a cached page still points
 * at.
 */
class IconGenerator
{
    /** PNG sizes browsers, Android and iOS ask for. */
    public const SIZES = [16, 32, 48, 64, 96, 120, 128, 144, 152, 167, 180, 192, 256, 384, 512];

    /** Sizes packed into favicon.ico for legacy clients. */
    private const ICO_SIZES = [16, 32, 48];

    /**
     * Sizes iOS uses. They are flattened onto an opaque square, because iOS
     * fills transparency with black and rounds the corners itself.
     */
    private const APPLE_SIZES = [120, 152, 167, 180];

    /**
     * Generate every size from the uploaded source.
     *
     * @param  string  $source  Path on the public disk, e.g. `branding/logo.png`
     * @param  string  $background  Hex colour behind the iOS sizes
     * @return array<string, string>  size (or "ico") => path on the public disk
     */
    public static function generate(string $source, string $background = '#0d1117'): array
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($source)) {
            return [];
        }

        $binary = $disk->get($source);
        // The colour is baked into the Apple sizes, so it belongs in the key.
        $folder = 'branding/icons/' . substr(md5($binary . $background), 0, 12);

        // Already built for this exact image.
        if ($disk->exists("$folder/icon-512.png")) {
            return self::pathsIn($folder, $disk->exists("$folder/favicon.ico"));
        }

        $image = @imagecreatefromstring($binary);

        if ($image === false) {
            Log::warning("Favicon source [$source] is not a readable raster image.");

            return [];
        }

        $square = self::square($image);

        foreach (self::SIZES as $size) {
            $icon = self::resize($square, $size);

            if (in_array($size, self::APPLE_SIZES, true)) {
                $icon = self::flatten($icon, $background);
            }

            $disk->put("$folder/icon-$size.png", self::encode($icon));
        }

        $ico = self::ico($square);
        if ($ico !== null) {
            $disk->put("$folder/favicon.ico", $ico);
        }


        return self::pathsIn($folder, $ico !== null);
    }

    /** @return array<string, string> */
    private static function pathsIn(string $folder, bool $withIco): array
    {
        $paths = [];

        foreach (self::SIZES as $size) {
            $paths[(string) $size] = "$folder/icon-$size.png";
        }

        if ($withIco) {
            $paths['ico'] = "$folder/favicon.ico";
        }

        return $paths;
    }

    /**
     * Pad a non-square upload onto a transparent square canvas rather than
     * cropping it — a logo that loses its edges is worse than one with margin.
     *
     * @param  \GdImage  $image
     * @return \GdImage
     */
    private static function square($image)
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $side = max($width, $height);

        $canvas = imagecreatetruecolor($side, $side);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        imagefill($canvas, 0, 0, imagecolorallocatealpha($canvas, 0, 0, 0, 127));
        imagealphablending($canvas, true);

        imagecopy(
            $canvas,
            $image,
            intdiv($side - $width, 2),
            intdiv($side - $height, 2),
            0,
            0,
            $width,
            $height
        );

        return $canvas;
    }

    /**
     * @param  \GdImage  $square
     * @return \GdImage
     */
    private static function resize($square, int $size)
    {
        $target = imagecreatetruecolor($size, $size);
        imagealphablending($target, false);
        imagesavealpha($target, true);
        imagefill($target, 0, 0, imagecolorallocatealpha($target, 0, 0, 0, 127));

        imagecopyresampled(
            $target,
            $square,
            0,
            0,
            0,
            0,
            $size,
            $size,
            imagesx($square),
            imagesy($square)
        );

        return $target;
    }

    /**
     * Composite an icon onto an opaque square of `$hex`.
     *
     * @param  \GdImage  $icon
     * @return \GdImage
     */
    private static function flatten($icon, string $hex)
    {
        $size = imagesx($icon);
        [$red, $green, $blue] = self::rgb($hex);

        $canvas = imagecreatetruecolor($size, $size);
        imagefill($canvas, 0, 0, imagecolorallocate($canvas, $red, $green, $blue));
        imagealphablending($canvas, true);
        imagecopy($canvas, $icon, 0, 0, 0, 0, $size, $size);
        imagesavealpha($canvas, false);

        return $canvas;
    }

    /**
     * @return array{int, int, int}  Falls back to the dark brand background.
     */
    private static function rgb(string $hex): array
    {
        $hex = ltrim(trim($hex), '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        if (! preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
            $hex = '0d1117';
        }

        return [
            (int) hexdec(substr($hex, 0, 2)),
            (int) hexdec(substr($hex, 2, 2)),
            (int) hexdec(substr($hex, 4, 2)),
        ];
    }

    /** @param  \GdImage  $image */
    private static function encode($image): string
    {
        ob_start();
        imagepng($image, null, 9);

        return (string) ob_get_clean();
    }

    /**
     * Minimal ICO container holding PNG-encoded entries — the format every
     * browser released this decade accepts, and the one /favicon.ico needs.
     *
     * @param  \GdImage  $square
     */
    private static function ico($square): ?string
    {
        $entries = [];

        foreach (self::ICO_SIZES as $size) {
            $entries[$size] = self::encode(self::resize($square, $size));
        }

        if ($entries === []) {
            return null;
        }

        // ICONDIR: reserved, type 1 (icon), image count.
        $header = pack('vvv', 0, 1, count($entries));
        $directory = '';
        $body = '';
        $offset = 6 + (16 * count($entries));

        foreach ($entries as $size => $png) {
            $directory .= pack(
                'CCCCvvVV',
                $size >= 256 ? 0 : $size, // width  (0 means 256)
                $size >= 256 ? 0 : $size, // height
                0,                        // palette colours
                0,                        // reserved
                1,                        // colour planes
                32,                       // bits per pixel
                strlen($png),
                $offset
            );

            $body .= $png;
            $offset += strlen($png);
        }

        return $header . $directory . $body;
    }
}
