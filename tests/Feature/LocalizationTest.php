<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_switch_locale_to_kurdish(): void
    {
        $response = $this->get(route('locale.switch', 'ku'));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'ku');
    }

    public function test_user_can_switch_locale_to_english(): void
    {
        $response = $this->withSession(['locale' => 'ku'])
            ->get(route('locale.switch', 'en'));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');
    }

    public function test_invalid_locale_is_ignored(): void
    {
        $response = $this->withSession(['locale' => 'en'])
            ->get(route('locale.switch', 'fr'));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');
    }

    public function test_page_renders_with_kurdish_rtl_and_translations_when_locale_is_ku(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['locale' => 'ku'])
            ->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('lang="ku"', false);
        $response->assertSee('بەستەرەکانم');
    }

    public function test_public_profile_page_renders_with_kurdish_when_locale_is_ku(): void
    {
        $user = User::factory()->create(['username' => 'testcreator']);

        $response = $this->withSession(['locale' => 'ku'])
            ->get(route('profile.public', $user->username));

        $response->assertOk();
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('lang="ku"', false);
    }
}
