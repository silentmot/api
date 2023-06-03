<?php

namespace Afaqy\User\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListUserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function it_prevents_unauthenticated_user_from_list_users()
    {
        $this->json('GET', '/api/v1/users?all_pages=0')
            ->assertStatus(401)
            ->assertJsonStructure(['message']);
    }

    /** @test */
    public function it_shows_users_list()
    {
        $owner = $this->createOwner();
        $this->createUsers(5, 'operator');

        $this->actingAs($owner, 'api')
            ->json('GET', '/api/v1/users?all_pages=0')
            ->assertOk()
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'message',
                'data' => [
                    ["id", "full_name", "username", "email", "phone", "avatar", "role", "status"],
                ],
            ]);
    }

    /** @test */
    public function it_shows_users_list_paginated_by_default()
    {
        $owner = $this->createOwner();
        $this->createUsers(5, 'operator');

        $this->actingAs($owner, 'api')
            ->json('GET', '/api/v1/users')
            ->assertOk()
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'message',
                'data' => [
                    ["id", "full_name", "username", "email", "phone", "avatar", "role", "status"],
                ],
                'meta' => [
                    "pagination" => [
                        "current_page",
                        "first_page",
                        "last_page",
                        "per_page",
                        "count",
                        "total_records",
                        "links" => ["first", "last", "previous", "next"],
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_filters_users_names_when_pass_username_parameter()
    {
        $owner    = $this->createOwner();
        $operator = $this->createUser('operator');
        $this->createUsers(5, 'employee');

        $this->actingAs($owner, 'api')
            ->json('GET', '/api/v1/users?all_pages=0&keyword=' . $operator->username)
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'message',
                'data' => [
                    ["id", "full_name", "username", "email", "phone", "avatar", "role"],
                ],
            ]);
    }

    /** @test */
    public function it_filters_users_when_pass_email_parameter()
    {
        $owner    = $this->createOwner();
        $operator = $this->createUser('operator');
        $this->createUsers(5, 'employee');

        $this->actingAs($owner, 'api')
            ->json('GET', '/api/v1/users?all_pages=0&keyword=' . $operator->email)
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'message',
                'data' => [
                    ["id", "full_name", "username", "email", "phone", "avatar", "role"],
                ],
            ]);
    }

    /** @test */
    public function it_filters_users_when_pass_role_parameter()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /** @test */
    public function it_returns_validation_error_when_pass_invalid_sort_columns()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /** @test */
    public function it_returns_validation_error_when_pass_invalid_direction_value()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /** @test */
    public function it_sorts_with_the_given_direction_when_pass_direction_parameter()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /** @test */
    public function it_returns_validation_error_when_pass_per_page_less_than_10_items()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /** @test */
    public function it_limits_records_by_the_given_per_page_parameter()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
