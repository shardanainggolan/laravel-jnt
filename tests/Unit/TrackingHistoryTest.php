<?php

namespace Nextlogique\Jnt\Tests\Unit;

use Nextlogique\Jnt\Http\Response\Tracking\History;
use Nextlogique\Jnt\Tests\TestCase;

class TrackingHistoryTest extends TestCase
{
    /** @test */
    public function it_casts_data_correctly()
    {
        $history = new History([
            "date" => "02-09-2019 23:25",
            "desc" => "RECEIVED AT SORTING CENTER [JAKARTA]",
        ]);

        $this->assertEquals('2019-09-02 23:25:00', $history->date->toDateTimeString());
        $this->assertEquals('RECEIVED AT SORTING CENTER [JAKARTA]', $history->desc);
    }
}
