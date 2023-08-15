<?php

namespace Nextlogique\Jnt\Http;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Nextlogique\Jnt\Http\Response\TariffResponse;
use Nextlogique\Jnt\Http\Response\StockAwbResponse;
use Nextlogique\Jnt\Http\Response\TrackingResponse;
use Nextlogique\Jnt\Http\Requests\Contracts\Request;
use Nextlogique\Jnt\Http\Response\GenerateAwbResponse;

class Client
{
    const ORDER_URL = '/jts-idn-ecommerce-api/api/order/create';
    const TARIFF_URL = '/tracing/api/pricedev';
    const TRACKING_URL = '/tracing/api/list/v1/cnote';
    const CANCELLATION_URL = '/jts-idn-ecommerce-api/api/order/cancel';
    const GENERATE_AWB_URL = '/tracing/api/generatecnote';
    const PICKUP_URL = '/pickupcashless';
    const STOCK_AWB_URL = '/tracing/api/stockawb';

    protected string $baseUrl;
    protected string $username;
    protected string $key;
    protected string $passwordTrack;

    public function __construct(
        string $baseUrl,
        string $username,
        string $key
    ) {
        $this->baseUrl = $baseUrl;
        $this->username = $username;
        $this->key = $key;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getApiKey(): string
    {
        return $this->key;
    }

    public function tracking(string $awb): TrackingResponse
    {
        $response = $this->post(self::TRACKING_URL."/$awb", [
            'username' => $this->getUsername(),
            'key' => $this->getApiKey(),
        ]);

        return new TrackingResponse(
            $response->json(),
            $response->status(),
            $response->headers()
        );
    }

    public function generateAwb(Request $requestBody): GenerateAwbResponse
    {
        $requestBody->setCredentials($this->getUsername(), $this->getApiKey());

        $requestBody->validate();

        $response = $this->post(self::GENERATE_AWB_URL, $requestBody->toArray());

        return new GenerateAwbResponse(
            $response->json(),
            $response->status(),
            $response->headers()
        );
    }

    public function tariff(Request $requestBody): TariffResponse
    {
        $requestBody->setCredentials($this->getUsername(), $this->getApiKey());

        $requestBody->validate();

        $signature = $this->generateSignature($requestBody->toArray(), $this->key);

        // $response = $this->post(self::TARIFF_URL, $requestBody->toArray());
        $response = $this->post(self::TARIFF_URL, [
            'data'  => $requestBody->toArray(),
            'sign'  => $signature
        ]);

        return new TariffResponse(
            $response->json(),
            $response->status(),
            $response->headers()
        );
    }

    public function pickup(Request $requestBody)
    {
        //
    }

    public function stockAwb(Request $requestBody): StockAwbResponse
    {
        $requestBody->setCredentials($this->getUsername(), $this->getApiKey());

        $requestBody->validate();

        $response = $this->post(self::STOCK_AWB_URL, $requestBody->toArray());

        return new StockAwbResponse(
            $response->json(),
            $response->status(),
            $response->headers(),
        );
    }

    public function generateSignature($data, $key)
    {
        $signature = base64_encode(md5(($data_param).$key));
        return $signature;
    }

    public function post(string $url, array $data): Response
    {
        return Http::baseUrl($this->baseUrl)->asForm()->post($url, $data);
    }
}
