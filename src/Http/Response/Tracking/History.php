<?php

namespace Nextlogique\Jnt\Http\Response\Tracking;

use Nextlogique\Jnt\Http\Response\Factory;

/**
 * @property \Carbon\Carbon|null $dates
 * @property string|null $desc
 */
class History extends Factory
{
    protected array $dates = [
        'date',
    ];
}
