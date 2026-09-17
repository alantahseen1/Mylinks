<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_multiple_links(): void
    {
        $user = User::factory()->create([
            'username' => 'alan',
        ]);

        $this->actingAs($user)
            ->post(route('links.store'), [
                'title' => 'First Link',
                'url' => 'https://example.com/first',
            ])
            ->assertRedirect(route('links.index'));

        $this->actingAs($user)
            ->post(route('links.store'), [
                'title' => 'Second Link',
                'url' => 'https://example.com/second',
            ])
            ->assertRedirect(route('links.index'));

        $this->assertDatabaseHas('links', [
            'user_id' => $user->id,
            'title' => 'First Link',
            'url' => 'https://example.com/first',
        ]);

        $this->assertDatabaseHas('links', [
            'user_id' => $user->id,
            'title' => 'Second Link',
            'url' => 'https://example.com/second',
        ]);

        $this->assertDatabaseCount('links', 2);
    }

    public function test_dashboard_shows_a_link_performance_overview(): void
    {
        $user = User::factory()->create([
            'username' => 'alan',
            'profile_views' => 8,
        ]);
        $user->links()->create([
            'title' => 'Popular Link',
            'url' => 'https://example.com/popular',
            'clicks' => 5,
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Creator overview')
            ->assertSee('8')
            ->assertSee('5')
            ->assertSee('Popular Link');
    }

    public function test_user_can_reorder_links(): void
    {
        $user = User::factory()->create([
            'username' => 'alan',
        ]);
        $firstLink = $user->links()->create([
            'title' => 'First Link',
            'url' => 'https://example.com/first',
            'position' => 0,
        ]);
        $secondLink = $user->links()->create([
            'title' => 'Second Link',
            'url' => 'https://example.com/second',
            'position' => 1,
        ]);

        $this->actingAs($user)
            ->post(route('links.reorder'), [
                'ids' => [$secondLink->id, $firstLink->id],
            ])
            ->assertRedirect(route('links.index'));

        $this->assertDatabaseHas('links', [
            'id' => $secondLink->id,
            'position' => 0,
        ]);
        $this->assertDatabaseHas('links', [
            'id' => $firstLink->id,
            'position' => 1,
        ]);
    }

    public function test_public_links_page_shows_active_links_grouped_by_owner(): void
    {
        $user = User::factory()->create([
            'name' => 'Link Owner',
            'username' => 'link-owner',
            'bio' => 'My public links',
        ]);
        $otherUser = User::factory()->create([
            'username' => 'other-user',
        ]);

        $user->links()->create([
            'title' => 'Owner Link',
            'url' => 'https://example.com/owner',
        ]);
        $otherUser->links()->create([
            'title' => 'Other Link',
            'url' => 'https://example.com/other',
        ]);

        $this->get(route('links.public.index'))
            ->assertOk()
            ->assertSee('Link Owner')
            ->assertSee('My public links')
            ->assertSee('Owner Link')
            ->assertSee('Other Link')
            ->assertSee('other-user');
    }

    public function test_public_profile_visit_and_link_clicks_are_counted(): void
    {
        $user = User::factory()->create([
            'username' => 'alan',
        ]);
        $link = $user->links()->create([
            'title' => 'Tracked Link',
            'url' => 'https://example.com/tracked',
            'is_active' => true,
        ]);

        $this->get(route('profile.public', $user->username))->assertOk();
        $this->get(route('links.click', $link))
            ->assertRedirect('https://example.com/tracked');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_views' => 1,
        ]);
        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'clicks' => 1,
        ]);
    }

    public function test_owner_activity_is_not_counted_as_public_activity(): void
    {
        $user = User::factory()->create([
            'username' => 'alan',
        ]);
        $link = $user->links()->create([
            'title' => 'Owner Link',
            'url' => 'https://example.com/owner',
        ]);

        $this->actingAs($user)->get(route('profile.public', $user->username));
        $this->actingAs($user)->get(route('links.click', $link));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_views' => 0,
        ]);
        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'clicks' => 0,
        ]);
    }
}
