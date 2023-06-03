<?php

namespace Afaqy\User\Tests\Feature;

use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    /** @test */
    public function it_prevents_unauthenticated_user_from_update_user_profile()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /** @test */
    public function it_authenticated_passes_when_user_update_user_profile()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /** @test */
    public function it_returns_validation_error_when_pass_phone_parameter_with_wrong_format()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /** @test */
    public function it_returns_validation_error_when_pass_password_parameter_not_belong_to_him()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /** @test */
    public function it_returns_validation_error_when_pass_photo__with_max_size()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
