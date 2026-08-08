<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\PageSection;
use App\Support\IconGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BrandingIconsTest extends TestCase
{
    use RefreshDatabase;

    /** A readable square PNG on the public disk. */
    private function uploadSource(string $path = 'branding/source.png', int $side = 600): string
    {
        $image = imagecreatetruecolor($side, $side);
        imagefilledrectangle($image, 0, 0, $side, $side, imagecolorallocate($image, 0, 242, 254));

        ob_start();
        imagepng($image);
        Storage::disk('public')->put($path, (string) ob_get_clean());

        return $path;
    }

    private function brandingSection(array $shared): PageSection
    {
        $page = Page::create(['key' => 'layout', 'group' => 'layout', 'label' => 'Layout']);

        return PageSection::create([
            'page_id' => $page->id,
            'key' => 'branding',
            'type' => 'branding',
            'shared' => $shared,
        ]);
    }

    public function test_saving_a_favicon_source_generates_every_size(): void
    {
        Storage::fake('public');
        $source = $this->uploadSource();

        $section = $this->brandingSection(['favicon' => $source]);
        $icons = $section->fresh()->shared['icons'];

        foreach (IconGenerator::SIZES as $size) {
            $this->assertArrayHasKey((string) $size, $icons, "Missing the {$size}px icon.");
            Storage::disk('public')->assertExists($icons[(string) $size]);
        }

        $this->assertArrayHasKey('ico', $icons);
        Storage::disk('public')->assertExists($icons['ico']);
    }

    public function test_the_generated_ico_declares_its_entries(): void
    {
        Storage::fake('public');
        $section = $this->brandingSection(['favicon' => $this->uploadSource()]);

        $ico = Storage::disk('public')->get($section->fresh()->shared['icons']['ico']);
        [, $type, $count] = array_values(unpack('vreserved/vtype/vcount', substr($ico, 0, 6)));

        $this->assertSame(1, $type, 'ICO type must be 1 (icon).');
        $this->assertSame(3, $count, 'ICO should pack 16, 32 and 48 px entries.');
    }

    public function test_icons_are_published_as_urls(): void
    {
        Storage::fake('public');
        $this->brandingSection(['favicon' => $this->uploadSource()]);

        $response = $this->getJson('/api/content');

        $icons = $response->json('data.content.branding.icons');
        $this->assertStringStartsWith('http', $icons['512']);
        $this->assertStringContainsString('icon-512.png', $icons['512']);
    }

    public function test_removing_the_source_clears_the_generated_set(): void
    {
        Storage::fake('public');
        $section = $this->brandingSection(['favicon' => $this->uploadSource()]);

        $section->update(['shared' => ['favicon' => null]]);

        $this->assertSame([], $section->fresh()->shared['icons']);
    }

    public function test_a_second_save_reuses_the_existing_files(): void
    {
        Storage::fake('public');
        $section = $this->brandingSection(['favicon' => $this->uploadSource()]);
        $first = $section->fresh()->shared['icons'];

        $section->touch();

        $this->assertSame($first, $section->fresh()->shared['icons']);
    }
}
