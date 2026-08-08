<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\PageSection;
use App\Models\User;
use App\Support\Permissions;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The section form is generated from config/sections.php, so a broken
 * descriptor would only show up when the page is opened. These tests open one
 * page per section type.
 */
class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    /** Opening the panel needs an active account with a role. */
    private function admin(): User
    {
        $this->seed(RoleSeeder::class);

        return tap(User::factory()->create())->assignRole(Permissions::SUPER_ADMIN);
    }

    public function test_the_pages_list_renders(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/pages')
            ->assertOk();
    }

    public function test_every_section_type_builds_a_form(): void
    {
        $this->actingAs($this->admin());

        $page = Page::create(['key' => 'home', 'group' => 'page', 'label' => 'Home']);

        foreach (array_keys(config('sections.types')) as $index => $type) {
            $section = PageSection::create([
                'page_id' => $page->id,
                'key' => "probe.$type",
                'type' => $type,
                'sort_order' => $index,
            ]);

            $components = \App\Filament\Support\SectionSchema::make($type);

            $this->assertNotEmpty($components, "Section type [$type] produced no form fields.");
            $this->assertNotSame('', $section->typeLabel());
        }
    }

    public function test_the_page_editor_renders_with_its_sections(): void
    {
        $page = Page::create(['key' => 'about', 'group' => 'page', 'label' => 'About']);
        PageSection::create([
            'page_id' => $page->id,
            'key' => 'about.founder',
            'type' => 'founder',
            'data' => ['az' => ['name' => 'Həmid']],
        ]);

        $this->actingAs($this->admin())
            ->get("/admin/pages/{$page->id}/edit")
            ->assertOk()
            ->assertSee('Sections');
    }

    public function test_content_resources_still_render_with_the_seo_block(): void
    {
        $this->actingAs($this->admin());

        foreach (['services', 'projects', 'blog-posts'] as $slug) {
            $this->get("/admin/$slug/create")->assertOk()->assertSee('SEO &amp; sharing', false);
        }
    }
}
