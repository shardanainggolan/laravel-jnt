<?php

namespace Nextlogique\Jnt\Http\Response\AWB;

use Nextlogique\Jnt\Http\Response\Factory;

/**
 * @property string|null $awb
 * @property string|null $airwaybill
 */
class Awb extends Factory
{
    public function awb()
    {
        return $this->airwaybill ?? $this->cnote_no;
    }

    public function airwaybill()
    {
        return $this->attributes['airwaybill'] ?? $this->awb;
    }
}
