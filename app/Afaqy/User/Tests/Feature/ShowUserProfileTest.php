<?php

namespace Afaqy\User\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowUserProfileTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_prevents_unauthenticated_user_from_show_user_profile_info()
    {
        $this->json('GET', '/api/v1/users/profile')
            ->assertStatus(401)
            ->assertJsonStructure(['message']);
    }

    /** @test */
    public function it_authenticated_passes_when_user_show_user_profile()
    {
        $this->actingAs($this->createAdmin(), 'api')
            ->json('GET', '/api/v1/users/profile')
            ->assertOk()
            ->assertJsonStructure([
                'message',
                'data' => ["id", "full_name", "username", "email", "phone", "avatar"],
            ]);
    }

    /** @test */
    public function it_returns_error_when_pass_try_to_show_user_data_not_exists()
    {
        $owner = $this->createOwner();

        $this->actingAs($owner, 'api')
            ->json('GET', '/api/v1/users/1000')
            ->assertStatus(404)
            ->assertJsonStructure(['message', 'errors']);
    }
}
