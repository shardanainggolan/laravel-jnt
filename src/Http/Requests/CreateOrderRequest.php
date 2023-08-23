<?php

namespace Nextlogique\Jnt\Http\Requests;

use Nextlogique\Jnt\Http\Exceptions\InvalidGenerateAwbRequestException;
use Nextlogique\Jnt\Http\Requests\Contracts\Request as RequestContract;

class CreateOrderRequest implements RequestContract
{
    protected array $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function toArray(): array
    {
        return collect($this->attributes)->keyBy(function ($item, $key) {
            $key = strtolower($key);

            if ($key == 'username' || $key == 'api_key') {
                return $key;
            }

            return strtoupper($key);
        })
        ->toArray();
    }

    public function setUsername(string $username): self
    {
        $this->attributes['username'] = $username;

        return $this;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->attributes['api_key'] = $apiKey;

        return $this;
    }

    public function setCredentials(string $username, string $apiKey): self
    {
        return $this->setUsername($username)->setApiKey($apiKey);
    }

    /**
     * Validate the request body.
     *
     * @return void
     *
     * @throws \Nextlogique\Jnt\Http\Exceptions\InvalidGenerateAwbRequestException
     */
    public function validate(): void
    {
        $requiredParams = [
            'username',
            'api_key',
            'orderid',
            'shipper_name',
            'shipper_contact',
            'shipper_phone',
            'shipper_addr',
            'origin_code',
            'receiver_name',
            'receiver_phone',
            'receiver_addr',
            'receiver_zip',
            'destination_code',
            'receiver_area',
            'qty',
            'weight',
            'goodsdesc',
            'servicetype',
            // 'insurance',
            'orderdate',
            'item_name',
            // 'cod',
            'sendstarttime',
            'sendendtime',
            'expresstype',
            'goodsvalue',
        ];

        foreach ($requiredParams as $param) {
            if (! ($this->attributes[$param] ?? null)) {
                throw new InvalidGenerateAwbRequestException("$param is required.");
            }
        }

        return;
    }
}
