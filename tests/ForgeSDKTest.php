<?php

namespace Tests;

use EvoFone\Exceptions\FailedActionException;
use EvoFone\Exceptions\ForbiddenException;
use EvoFone\Exceptions\NotFoundException;
use EvoFone\Exceptions\RateLimitExceededException;
use EvoFone\Exceptions\TimeoutException;
use EvoFone\Exceptions\ValidationException;
use EvoFone\FoneEvo;
use EvoFone\MakesHttpRequests;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class ForgeSDKTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_making_basic_requests()
    {
        $forge = new FoneEvo('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
            new Response(200, [], '{"recipes": [{"key": "value"}]}')
        );

        $this->assertCount(1, $forge->recipes());
    }

    public function test_update_site()
    {
        $forge = new FoneEvo('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('PUT', 'servers/123/sites/456', [
            'json' => ['aliases' => ['foo.com']],
        ])->andReturn(
            new Response(200, [], '{"site": {"aliases": ["foo.com"]}}')
        );

        $this->assertSame(['foo.com'], $forge->updateSite('123', '456', [
            'aliases' => ['foo.com'],
        ])->aliases);
    }

    public function test_handling_validation_errors()
    {
        $forge = new FoneEvo('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
            new Response(422, [], '{"name": ["The name is required."]}')
        );

        try {
            $forge->recipes();
        } catch (ValidationException $e) {
        }

        $this->assertEquals(['name' => ['The name is required.']], $e->errors());
    }

    public function test_handling_404_errors()
    {
        $this->expectException(NotFoundException::class);

        $forge = new FoneEvo('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
            new Response(404)
        );

        $forge->recipes();
    }

    public function test_handling_forbidden_requests(): void
    {
        $this->expectException(ForbiddenException::class);

        $forge = new FoneEvo('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
            new Response(403)
        );

        $forge->recipes();
    }

    public function test_handling_failed_action_errors()
    {
        $forge = new FoneEvo('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
            new Response(400, [], 'Error!')
        );

        try {
            $forge->recipes();
        } catch (FailedActionException $e) {
            $this->assertSame('Error!', $e->getMessage());
        }
    }

    public function testRetryHandlesFalseResultFromClosure()
    {
        $requestMaker = new class
        {
            use MakesHttpRequests;
        };

        try {
            $requestMaker->retry(0, function () {
                return false;
            }, 0);
            $this->fail();
        } catch (TimeoutException $e) {
            $this->assertSame([], $e->output());
        }
    }

    public function testRetryHandlesNullResultFromClosure()
    {
        $requestMaker = new class
        {
            use MakesHttpRequests;
        };

        try {
            $requestMaker->retry(0, function () {
                return null;
            }, 0);
            $this->fail();
        } catch (TimeoutException $e) {
            $this->assertSame([], $e->output());
        }
    }

    public function testRetryHandlesFalseyStringResultFromClosure()
    {
        $requestMaker = new class
        {
            use MakesHttpRequests;
        };

        try {
            $requestMaker->retry(0, function () {
                return '';
            }, 0);
            $this->fail();
        } catch (TimeoutException $e) {
            $this->assertSame([''], $e->output());
        }
    }

    public function testRetryHandlesFalseyNumerResultFromClosure()
    {
        $requestMaker = new class
        {
            use MakesHttpRequests;
        };

        try {
            $requestMaker->retry(0, function () {
                return 0;
            }, 0);
            $this->fail();
        } catch (TimeoutException $e) {
            $this->assertSame([0], $e->output());
        }
    }

    public function testRetryHandlesFalseyArrayResultFromClosure()
    {
        $requestMaker = new class
        {
            use MakesHttpRequests;
        };

        try {
            $requestMaker->retry(0, function () {
                return [];
            }, 0);
            $this->fail();
        } catch (TimeoutException $e) {
            $this->assertSame([], $e->output());
        }
    }

    public function testRateLimitExceededWithHeaderSet()
    {
        $forge = new FoneEvo('123', $http = Mockery::mock(Client::class));

        $timestamp = strtotime(date('Y-m-d H:i:s'));

        $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
            new Response(429, [
                'x-ratelimit-reset' => $timestamp,
            ], 'Too Many Attempts.')
        );

        try {
            $forge->recipes();
        } catch (RateLimitExceededException $e) {
            $this->assertSame($timestamp, $e->rateLimitResetsAt);
        }
    }

    public function testRateLimitExceededWithHeaderNotAvailable()
    {
        $forge = new FoneEvo('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'recipes', [])->andReturn(
            new Response(429, [], 'Too Many Attempts.')
        );

        try {
            $forge->recipes();
        } catch (RateLimitExceededException $e) {
            $this->assertNull($e->rateLimitResetsAt);
        }
    }
}
