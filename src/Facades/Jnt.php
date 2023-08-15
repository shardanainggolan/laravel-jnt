<?php

namespace Nextlogique\Jnt\Facades;

use Nextlogique\Jnt\Http\Client;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Nextlogique\Jnt\Http\Response\TrackingResponse tracking(string $awb)
 * @method static \Nextlogique\Jnt\Http\Response\GenerateAwbResponse generateAwb(\Nextlogique\Jnt\Http\Requests\Contracts\Request $requestBody)
 * @method static \Nextlogique\Jnt\Http\Response\TariffResponse tariff(\Nextlogique\Jnt\Http\Requests\Contracts\Request $requestBody)
 * @method static \Nextlogique\Jnt\Http\Response\StockAwbResponse stockAwb(\Nextlogique\Jnt\Http\Requests\Contracts\Request $requestBody)
 * @method static \Illuminate\Http\Client\Response post(string $url, array $data)
 * @method static string getUsername()
 * @method static string getApiKey()
 *
 * @see \Illuminate\Http\Request
 */
class Jnt extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Client::class;
    }
}
