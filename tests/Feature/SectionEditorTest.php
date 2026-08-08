<?php

namespace Tests\Feature;

use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\RelationManagers\SectionsRelationManager;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * The block editor builds its fields from the section's type at runtime, so
 * these tests drive the real Livewire component rather than the static schema.
 */
class SectionEditorTest extends TestCase
{
    use RefreshDatabase;

    private Page $page;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
        $this->page = Page::create(['key' => 'home', 'group' => 'page', 'label' => 'Home']);
    }

    private function manager()
    {
        return Livewire::test(SectionsRelationManager::class, [
            'ownerRecord' => $this->page,
            'pageClass' => EditPage::class,
        ]);
    }

    public function test_an_editor_can_change_copy_in_one_language(): void
    {
        $section = PageSection::create([
            'page_id' => $this->page->id,
            'key' => 'home.cta',
            'type' => 'cta',
            'data' => [
                'az' => ['title' => 'Layihənizi başlayaq', 'subtitle' => 'Köhnə'],
                'en' => ['title' => 'Let us start', 'subtitle' => 'Old'],
            ],
        ]);

        $this->manager()
            ->mountTableAction('edit', $section)
            ->assertTableActionDataSet(fn (array $data) => $data['data']['en']['title'] === 'Let us start')
            ->setTableActionData([
                'key' => 'home.cta',
                'type' => 'cta',
                'is_visible' => true,
                'sort_order' => 0,
                'data' => [
                    'az' => ['title' => 'Layihənizi başlayaq', 'subtitle' => 'Köhnə'],
                    'en' => ['title' => 'Let us start', 'subtitle' => 'New subtitle'],
                ],
            ])
            ->callMountedTableAction()
            ->assertHasNoTableActionErrors();

        $section->refresh();

        $this->assertSame('New subtitle', $section->data['en']['subtitle']);
        // The other language is untouched.
        $this->assertSame('Köhnə', $section->data['az']['subtitle']);
    }

    public function test_a_repeater_block_round_trips_its_items(): void
    {
        $section = PageSection::create([
            'page_id' => $this->page->id,
            'key' => 'home.faq',
            'type' => 'faq',
            'data' => ['az' => ['title' => 'FAQ', 'items' => [['question' => 'Q1', 'answer' => 'A1']]]],
        ]);

        $this->manager()
            ->mountTableAction('edit', $section)
            ->setTableActionData([
                'key' => 'home.faq',
                'type' => 'faq',
                'is_visible' => true,
                'sort_order' => 0,
                'data' => [
                    'az' => [
                        'title' => 'FAQ',
                        'items' => [
                            'a' => ['question' => 'Q1', 'answer' => 'A1'],
                            'b' => ['question' => 'Q2', 'answer' => 'A2'],
                        ],
                    ],
                ],
            ])
            ->callMountedTableAction()
            ->assertHasNoTableActionErrors();

        $section->refresh();

        $items = array_values($section->data['az']['items']);
        $questions = array_column($items, 'question');

        $this->assertContains('Q2', $questions, 'The new repeater row was not saved.');
        foreach ($items as $item) {
            $this->assertArrayHasKey('answer', $item, 'Repeater rows lost their nested fields.');
        }
    }

    public function test_a_new_section_can_be_added_to_a_page(): void
    {
        $this->manager()
            ->mountTableAction('create')
            ->setTableActionData([
                'key' => 'home.notice',
                'type' => 'rich_text',
                'is_visible' => true,
                'sort_order' => 99,
                'data' => ['az' => [
                    'title' => 'Elan',
                    'body' => ['a' => ['value' => 'Birinci abzas']],
                ]],
            ])
            ->callMountedTableAction()
            ->assertHasNoTableActionErrors();

        $section = PageSection::where('key', 'home.notice')->firstOrFail();

        $this->assertSame('rich_text', $section->type);
        $this->assertSame('Elan', $section->data['az']['title']);

        // …and it reaches the site without any code change.
        $this->getJson('/api/content')->assertJsonPath('data.content.home.notice.title', 'Elan');
    }
}
