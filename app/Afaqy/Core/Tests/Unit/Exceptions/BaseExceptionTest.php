<?php

namespace Afaqy\Core\Tests\Unit\Exceptions;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Afaqy\Core\Exceptions\BaseException;

class BaseExceptionTest extends TestCase
{
    /** @test */
    public function it_renders_exception_in_afaqy_exception_format()
    {
        $testExcption = new class extends BaseException {
        };

        $response = $testExcption->render(request());

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertArrayHasKey('message', (array) $response->getData());
        $this->assertArrayHasKey('errors', (array) $response->getData());
        $this->assertArrayHasKey('debug', (array) $response->getData());
        $this->assertArrayHasKey('exception_message', (array) $response->getData()->debug);
        $this->assertArrayHasKey('exception_file', (array) $response->getData()->debug);
        $this->assertArrayHasKey('exception_line', (array) $response->getData()->debug);
    }

    /** @test */
    public function it_logs_the_exception()
    {
        $testExcption = new class extends BaseException {
        };

        Log::shouldReceive('error')
            ->once()
            ->with($testExcption);

        $testExcption->report();
    }
}
