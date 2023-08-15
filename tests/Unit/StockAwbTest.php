<?php

namespace Nextlogique\Jnt\Tests\Unit;

use Nextlogique\Jnt\Facades\Jnt;
use Nextlogique\Jnt\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Nextlogique\Jnt\Http\Requests\StockAwbRequest;
use Nextlogique\Jnt\Http\Response\StockAwbResponse;
use Nextlogique\Jnt\Http\Exceptions\InvalidStockAwbRequestException;

class StockAwbTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('jnt.api', [
            'username' => 'jnt-api-username',
            'key' => 'jnt-api-key',
            'url' => 'https://jnt-api-url',
        ]);
    }

    /** @test */
    public function it_send_to_stock_awb_api_correctly()
    {
        Http::fake([
            '*' => Http::response($this->successResponse()),
        ]);

        Jnt::stockAwb($this->requestBody());

        Http::assertSent(function (Request $request) {
            return $request->hasHeader('Content-Type', 'application/x-www-form-urlencoded') &&
                $request->url() == 'https://jnt-api-url/tracing/api/stockawb' &&
                $request['username'] == 'jnt-api-username' &&
                $request['api_key'] == 'jnt-api-key' &&
                $request['BRANCH'] == 'branch' &&
                $request['CUST_ID'] == 'account-id' &&
                $request['CREATE_BY'] == 'pic-generate' &&
                $request['REQUEST_AWB'] == 5 &&
                $request['REQUEST_BY'] == 'pic-requester' &&
                $request['REQUEST_NO'] == 'unique-number' &&
                $request['REASON'] == 'reason';
        });
    }

    /** @test */
    public function it_sets_stock_awb_response_from_success_response()
    {
        Http::fake([
            '*' => Http::response($this->successResponse()),
        ]);

        $response = Jnt::stockAwb($this->requestBody());

        tap($response->awb, function ($awb) {
            $this->assertInstanceOf(Collection::class, $awb);
            $this->assertEquals(5, $awb->count());
        });

        $this->assertEquals('2000281900500044', $response->awb->first()->airwaybill);
    }

    /** @test */
    public function it_validates_before_sending_stock_awb_request()
    {
        $this->expectException(InvalidStockAwbRequestException::class);

        Http::fake([
            '*' => Http::response($this->successResponse()),
        ]);

        $response = Jnt::stockAwb(new StockAwbRequest([]));

        Http::assertNothingSent();
    }

    /** @test */
    public function it_return_correct_response_for_stock_awb_requests()
    {
        Http::fake([
            '*' => Http::response([
                'error' => "Username And API KEY Must Be Sent.",
                'status' => "false",
            ]),
        ]);

        $response = Jnt::stockAwb($this->requestBody());

        $this->assertInstanceOf(StockAwbResponse::class, $response);
    }

    protected function requestBody(): StockAwbRequest
    {
        return new StockAwbRequest([
            'BRANCH' => 'branch',
            'CUST_ID' => 'account-id',
            'CREATE_BY' => 'pic-generate',
            'REQUEST_AWB' => 5,
            'REQUEST_BY' => 'pic-requester',
            'REQUEST_NO' => 'unique-number',
            'REASON' => 'reason',
        ]);
    }

    protected function successResponse(): array
    {
        return [
            "awb" => [
                [
                    "airwaybill" => "2000281900500044"
                ],
                [
                    "airwaybill" => "2000281900500051"
                ],
                [
                    "airwaybill" => "2000281900500069"
                ],
                [
                    "airwaybill" => "2000281900500077"
                ],
                [
                    "airwaybill" => "2000281900500085"
                ],
            ],
        ];
    }
}
