<?php

namespace Tests\Feature;

use App\Filament\Resources\PageResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\ServiceResource;
use App\Filament\Resources\UserResource;
use App\Models\Page;
use App\Models\User;
use App\Support\Permissions;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function userWithRole(string $role): User
    {
        return tap(User::factory()->create())->assignRole($role);
    }

    public function test_an_account_without_a_role_cannot_open_the_admin(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->canAccessPanel(app(\Filament\Panel::class)));
        $this->actingAs($user)->get('/admin/pages')->assertForbidden();
    }

    public function test_a_deactivated_account_cannot_open_the_admin(): void
    {
        $user = $this->userWithRole(Permissions::SUPER_ADMIN);
        $user->update(['is_active' => false]);

        $this->assertFalse($user->fresh()->canAccessPanel(app(\Filament\Panel::class)));
    }

    public function test_the_super_admin_may_do_everything(): void
    {
        $this->actingAs($this->userWithRole(Permissions::SUPER_ADMIN));

        $this->assertTrue(PageResource::canViewAny());
        $this->assertTrue(UserResource::canViewAny());
        $this->assertTrue(RoleResource::canViewAny());
        $this->assertTrue(ServiceResource::canCreate());
    }

    public function test_the_super_admin_keeps_permissions_added_later(): void
    {
        $this->actingAs($this->userWithRole(Permissions::SUPER_ADMIN));

        // Nothing granted it this explicitly — the rule covers it.
        $this->assertTrue(auth()->user()->can('something.invented.tomorrow'));
    }

    public function test_an_editor_manages_content_but_not_accounts(): void
    {
        $this->actingAs($this->userWithRole('editor'));

        $this->assertTrue(ServiceResource::canViewAny());
        $this->assertTrue(ServiceResource::canCreate());
        $this->assertTrue(PageResource::canViewAny());

        $this->assertFalse(UserResource::canViewAny());
        $this->assertFalse(RoleResource::canViewAny());
    }

    public function test_an_editor_cannot_add_or_remove_pages(): void
    {
        $this->actingAs($this->userWithRole('editor'));
        $page = Page::create(['key' => 'home', 'group' => 'page', 'label' => 'Home']);

        $this->assertTrue(PageResource::canEdit($page));
        $this->assertFalse(PageResource::canCreate());
        $this->assertFalse(PageResource::canDelete($page));
    }

    public function test_a_viewer_can_only_look(): void
    {
        $this->actingAs($this->userWithRole('viewer'));
        $page = Page::create(['key' => 'home', 'group' => 'page', 'label' => 'Home']);

        $this->assertTrue(PageResource::canViewAny());
        $this->assertFalse(PageResource::canEdit($page));
        $this->assertFalse(ServiceResource::canCreate());
    }

    public function test_a_forbidden_resource_route_is_refused(): void
    {
        $this->actingAs($this->userWithRole('editor'));

        $this->get('/admin/users')->assertForbidden();
        $this->get('/admin/pages')->assertOk();
    }

    public function test_permissions_can_be_granted_through_a_custom_role(): void
    {
        $role = Role::create(['name' => 'lead-desk', 'guard_name' => 'web']);
        $role->syncPermissions(['leads.view', 'leads.update']);

        $user = tap(User::factory()->create())->assignRole($role);
        $this->actingAs($user);

        $this->assertTrue($user->can('leads.view'));
        $this->assertFalse($user->can('leads.delete'));
        $this->assertFalse(ServiceResource::canViewAny());
    }

    public function test_the_catalogue_covers_every_admin_area(): void
    {
        // A resource with no matching subject would silently be open to all.
        foreach (['pages', 'services', 'projects', 'blog_posts', 'leads', 'users', 'roles'] as $subject) {
            $this->assertArrayHasKey($subject, Permissions::subjects());
        }

        $this->assertCount(28, Permissions::all());
    }
}
