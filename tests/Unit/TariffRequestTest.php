<?php

namespace Nextlogique\Jnt\Tests\Unit;

use Nextlogique\Jnt\Facades\Jnt;
use Nextlogique\Jnt\Tests\TestCase;
use Illuminate\Support\Collection;
use Nextlogique\Jnt\Http\Requests\TariffRequest;
use Nextlogique\Jnt\Http\Exceptions\InvalidTariffRequestException;
use Nextlogique\Jnt\Http\Requests\Contracts\Request as RequestContract;

class TariffRequestTest extends TestCase
{
    /** @test */
    public function it_implements_request_contract()
    {
        $this->assertInstanceOf(RequestContract::class, new TariffRequest([]));
    }

    /**
     * @test
     * @dataProvider requestBodyValidationProvider
     */
    public function test_body_validation($bodyName, $bodyValue, $exceptionMessage)
    {
        $this->expectException(InvalidTariffRequestException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $tariffRequest = new TariffRequest($this->body([
            $bodyName => $bodyValue,
        ]));

        $tariffRequest->validate();
    }

    protected function body(?array $overrides = []): array
    {
        return array_merge([
            'username' => '::username::',
            'api_key' => '::api_key::',
            'from' => '::from::',
            'thru' => '::thru::',
            'weight' => 1,
        ], $overrides);
    }

    public function requestBodyValidationProvider(): array
    {
        return [
            'Test username is required' => ['username', '', 'username is required.'],
            'Test api_key is required' => ['api_key', '', 'api_key is required.'],
            'Test from is required' => ['from', '', 'from is required.'],
            'Test thru is required' => ['thru', '', 'thru is required.'],
            'Test weight is required' => ['weight', '', 'weight is required.'],
            'Test weight is valid' => ['weight', 'not-a-number', 'weight must be a number.'],
        ];
    }
}
