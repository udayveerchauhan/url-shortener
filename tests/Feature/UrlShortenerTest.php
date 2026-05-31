<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    private function createUserWithRole(string $role, ?Company $company = null): User
    {
        if ($role === 'SuperAdmin') {
            $user = User::factory()->create(['company_id' => null]);
        } else {
            $company ??= Company::factory()->create();
            $user = User::factory()->create(['company_id' => $company->id]);
        }

        $user->assignRole($role);

        return $user;
    }

    public function test_admin_cannot_create_short_urls(): void
    {
        $admin = $this->createUserWithRole('Admin');

        $response = $this->actingAs($admin)->post(route('short-urls.store'), [
            'original_url' => 'https://example.com',
        ]);

        $response->assertForbidden();
    }

    public function test_member_cannot_create_short_urls(): void
    {
        $member = $this->createUserWithRole('Member');

        $response = $this->actingAs($member)->post(route('short-urls.store'), [
            'original_url' => 'https://example.com',
        ]);

        $response->assertForbidden();
    }

    public function test_superadmin_cannot_create_short_urls(): void
    {
        $superAdmin = $this->createUserWithRole('SuperAdmin');

        $response = $this->actingAs($superAdmin)->post(route('short-urls.store'), [
            'original_url' => 'https://example.com',
        ]);

        $response->assertForbidden();
    }

    public function test_admin_sees_only_urls_not_created_in_their_own_company(): void
    {
        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $admin = $this->createUserWithRole('Admin', $companyA);

        ShortUrl::factory()->create([
            'company_id' => $companyA->id,
            'user_id' => User::factory()->create(['company_id' => $companyA->id])->id,
            'original_url' => 'https://a-company.example.com',
        ]);

        $available = ShortUrl::factory()->create([
            'company_id' => $companyB->id,
            'user_id' => User::factory()->create(['company_id' => $companyB->id])->id,
            'original_url' => 'https://b-company.example.com',
        ]);

        $response = $this->actingAs($admin)->get(route('short-urls.index'));

        $response->assertOk();
        $response->assertSee($available->short_code);
        $response->assertDontSee('https://a-company.example.com');
    }

    public function test_member_sees_only_urls_not_created_by_themselves(): void
    {
        $company = Company::factory()->create();
        $member = $this->createUserWithRole('Member', $company);
        $otherUser = User::factory()->create(['company_id' => $company->id]);

        $ownUrl = ShortUrl::factory()->create([
            'company_id' => $company->id,
            'user_id' => $member->id,
            'original_url' => 'https://member.example.com',
        ]);

        $otherUrl = ShortUrl::factory()->create([
            'company_id' => $company->id,
            'user_id' => $otherUser->id,
            'original_url' => 'https://colleague.example.com',
        ]);

        $response = $this->actingAs($member)->get(route('short-urls.index'));

        $response->assertOk();
        $response->assertSee($otherUrl->short_code);
        $response->assertDontSee($ownUrl->short_code);
    }

    public function test_public_short_url_resolution_returns_403(): void
    {
        $response = $this->get('/s/test-code');

        $response->assertStatus(403);
        $response->assertExactJson(['message' => 'Public resolution disabled']);
    }
}
