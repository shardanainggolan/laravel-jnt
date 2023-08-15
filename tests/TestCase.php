<?php

namespace Nextlogique\Jnt\Tests;

use Nextlogique\Jnt\Providers\JntServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        //
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            JntServiceProvider::class,
        ];
    }
}
