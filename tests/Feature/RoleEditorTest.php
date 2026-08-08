<?php

namespace Tests\Feature;

use App\Filament\Resources\RoleResource\Pages\CreateRole;
use App\Filament\Resources\RoleResource\Pages\EditRole;
use App\Models\User;
use App\Support\Permissions;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * The role form splits one flat permission list across a checkbox group per
 * subject, so the translation between the two is worth driving for real.
 */
class RoleEditorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
        $this->actingAs(tap(User::factory()->create())->assignRole(Permissions::SUPER_ADMIN));
    }

    public function test_a_role_can_be_created_with_permissions_from_several_groups(): void
    {
        Livewire::test(CreateRole::class)
            ->fillForm([
                'name' => 'lead-desk',
                'guard_name' => 'web',
                'permission_groups' => [
                    'leads' => ['leads.view', 'leads.update'],
                    'blog-posts' => ['blog_posts.view'],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $role = Role::where('name', 'lead-desk')->firstOrFail();

        $this->assertEqualsCanonicalizing(
            ['leads.view', 'leads.update', 'blog_posts.view'],
            $role->permissions->pluck('name')->all()
        );
    }

    public function test_editing_shows_the_current_grants_and_saves_changes(): void
    {
        $role = Role::where('name', 'viewer')->firstOrFail();

        Livewire::test(EditRole::class, ['record' => $role->getKey()])
            // The seeded viewer grants are spread back into their groups.
            ->assertFormSet(fn (array $data) => in_array(
                'pages.view',
                $data['permission_groups']['pages-sections'] ?? [],
                true
            ))
            ->fillForm([
                'permission_groups' => [
                    'pages-sections' => ['pages.view', 'pages.update'],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $granted = $role->fresh()->permissions->pluck('name')->all();

        $this->assertContains('pages.update', $granted, 'The edited group was not saved.');
        // Editing one group must leave the other subjects alone.
        $this->assertContains('leads.view', $granted);
        $this->assertContains('services.view', $granted);
        $this->assertNotContains('services.update', $granted);
    }

    public function test_the_super_admin_role_stores_no_grants(): void
    {
        $role = Role::where('name', Permissions::SUPER_ADMIN)->firstOrFail();

        Livewire::test(EditRole::class, ['record' => $role->getKey()])
            ->fillForm(['permission_groups' => ['users' => ['users.delete']]])
            ->call('save')
            ->assertHasNoFormErrors();

        // It passes every check by rule, so grants would only drift.
        $this->assertCount(0, $role->fresh()->permissions);
    }
}
