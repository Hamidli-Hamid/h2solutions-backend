<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\PageSection;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_sections_are_assembled_into_a_nested_tree(): void
    {
        $page = Page::create(['key' => 'about', 'group' => 'page', 'label' => 'About']);

        PageSection::create([
            'page_id' => $page->id,
            'key' => 'about.founder',
            'type' => 'founder',
            'data' => ['az' => ['name' => 'Həmid'], 'en' => ['name' => 'Hamid']],
        ]);

        PageSection::create([
            'page_id' => $page->id,
            'key' => 'about',
            'type' => 'about_intro',
            'data' => ['az' => ['title' => 'Haqqımızda'], 'en' => ['title' => 'About us']],
        ]);

        $response = $this->withHeader('X-Locale', 'en')->getJson('/api/content');

        $response->assertOk();
        // The parent block must not swallow the child that was filed separately.
        $response->assertJsonPath('data.content.about.title', 'About us');
        $response->assertJsonPath('data.content.about.founder.name', 'Hamid');
    }

    public function test_a_missing_translation_falls_back_to_the_default_locale(): void
    {
        $page = Page::create(['key' => 'home', 'group' => 'page', 'label' => 'Home']);

        PageSection::create([
            'page_id' => $page->id,
            'key' => 'home.cta',
            'type' => 'cta',
            'data' => [
                'az' => ['title' => 'Başlayaq', 'subtitle' => 'Yazın'],
                'de' => ['title' => 'Los geht’s'],
            ],
        ]);

        $this->withHeader('X-Locale', 'de')->getJson('/api/content')
            ->assertJsonPath('data.content.home.cta.title', 'Los geht’s')
            ->assertJsonPath('data.content.home.cta.subtitle', 'Yazın');
    }

    public function test_hidden_sections_are_not_published(): void
    {
        $page = Page::create(['key' => 'home', 'group' => 'page', 'label' => 'Home']);

        PageSection::create([
            'page_id' => $page->id,
            'key' => 'home.faq',
            'type' => 'faq',
            'data' => ['az' => ['title' => 'FAQ']],
            'is_visible' => false,
        ]);

        $this->getJson('/api/content')->assertJsonMissingPath('data.content.home');
    }

    public function test_page_seo_overrides_are_published_and_blanks_are_dropped(): void
    {
        Page::create([
            'key' => 'contact',
            'group' => 'page',
            'label' => 'Contact',
            'seo_title' => ['az' => 'Əlaqə — H2', 'en' => 'Contact — H2'],
            'robots_index' => false,
        ]);

        $response = $this->withHeader('X-Locale', 'en')->getJson('/api/content');

        $response->assertJsonPath('data.seo.contact.title', 'Contact — H2');
        $response->assertJsonPath('data.seo.contact.robots.index', false);
        $response->assertJsonMissingPath('data.seo.contact.description');
    }

    public function test_services_carry_their_own_seo_overrides(): void
    {
        Service::create([
            'slug' => 'seo',
            'title' => ['az' => 'SEO'],
            'summary' => ['az' => 'Qısa'],
            'description' => ['az' => 'Uzun'],
            'seo_title' => ['az' => 'SEO xidməti — H2'],
            'robots_follow' => false,
        ]);

        $this->getJson('/api/services')
            ->assertJsonPath('data.0.seo.title', 'SEO xidməti — H2')
            ->assertJsonPath('data.0.seo.robots.follow', false);
    }

    public function test_editing_a_section_invalidates_the_cached_tree(): void
    {
        $page = Page::create(['key' => 'home', 'group' => 'page', 'label' => 'Home']);
        $section = PageSection::create([
            'page_id' => $page->id,
            'key' => 'home.cta',
            'type' => 'cta',
            'data' => ['az' => ['title' => 'Before']],
        ]);

        $this->getJson('/api/content')->assertJsonPath('data.content.home.cta.title', 'Before');

        $section->update(['data' => ['az' => ['title' => 'After']]]);

        $this->getJson('/api/content')->assertJsonPath('data.content.home.cta.title', 'After');
    }
}
