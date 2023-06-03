<?php

namespace Afaqy\Core\Tests\Unit\Http\Responses;

use Tests\TestCase;
use ArrayKeysCaseTransform\ArrayKeys;
use Afaqy\Core\Http\Responses\ResponseBuilder;

class ResponseBuilderTest extends TestCase
{
    /** @test */
    public function it_returns_success_response()
    {
        $data = [
            'id'   => 1,
            'name' => 'Test Name',
        ];

        $message = 'Done';

        $response = new ResponseBuilderDummy;
        $response = $response->returnSuccess($message, $data);
        $response = json_decode((string) $response->getContent(), true);

        $this->assertEquals($message, $response['message']);
        $this->assertEquals(ArrayKeys::toSnakeCase($data), $response['data']);
    }

    /** @test */
    public function it_returns_paginated_response()
    {
        $data = [
            'data' => [
                [
                    'id'   => 1,
                    'name' => 'Test Name',
                ],
            ],
            'meta' => [
                "pagination" => [
                    "current_page"  => 1,
                    "first_page"    => 1,
                    "last_page"     => 3,
                    "per_page"      => 15,
                    "count"         => 15,
                    "total_records" => 45,
                    "links"         => [
                        "first"    => "http://dev.core.loc/api/posts?order=id%2Casc&page=1",
                        "last"     => "http:/dev.core.loc/api/posts?order=id%2Casc&page=3",
                        "previous" => null,
                        "next"     => "http://dev.core.loc/api/posts?order=id%2Casc&page=2",
                    ],
                ],
            ],
        ];

        $message = 'Done';

        $response = new ResponseBuilderDummy;
        $response = $response->returnSuccess($message, $data);
        $response = json_decode((string) $response->getContent(), true);

        $this->assertEquals($message, $response['message']);
        $this->assertEquals(ArrayKeys::toSnakeCase($data['data']), $response['data']);
        $this->assertEquals(ArrayKeys::toSnakeCase($data['meta']), $response['meta']);
    }

    /** @test */
    public function it_returns_response_with_additional_information()
    {
        $data = [
            'data' => [
                [
                    'id'   => 1,
                    'name' => 'Test Name',
                ],
            ],
            'additionalInformation' => [
                'ref' => 'http://some-documentations.org/',
            ],
        ];

        $message = 'Done';

        $response = new ResponseBuilderDummy;
        $response = $response->returnSuccess($message, $data);
        $response = json_decode((string) $response->getContent(), true);

        $this->assertEquals($message, $response['message']);
        $this->assertEquals(ArrayKeys::toSnakeCase($data['data']), $response['data']);
        $this->assertEquals(ArrayKeys::toSnakeCase($data['additionalInformation']), $response['additional_information']);
    }

    /** @test */
    public function it_returns_error_response()
    {
        $header_code = 422;

        $errors = [
            'link' => 'http://some-documentations.org/',
        ];

        $message = 'error';

        $response    = new ResponseBuilderDummy;
        $response    = $response->returnError($header_code, $message, $errors);
        $status_code = $response->getStatusCode();
        $response    = json_decode((string) $response->getContent(), true);

        $this->assertEquals($header_code, $status_code);
        $this->assertEquals($message, $response['message']);
        $this->assertEquals(ArrayKeys::toSnakeCase($errors), $response['errors']);
    }

    /** @test */
    public function it_returns_bad_request()
    {
        $internal_code = 1039;

        $errors = [
            'link' => 'http://some-documentations.org/',
        ];

        $message = 'error';

        $response    = new ResponseBuilderDummy;
        $response    = $response->returnBadRequest($internal_code, $message, $errors);
        $status_code = $response->getStatusCode();
        $response    = json_decode((string) $response->getContent(), true);

        $this->assertEquals(400, $status_code);
        $this->assertEquals($internal_code, $response['code']);
        $this->assertEquals(ArrayKeys::toSnakeCase($errors), $response['errors']);
    }
}


class ResponseBuilderDummy
{
    use ResponseBuilder;
}
