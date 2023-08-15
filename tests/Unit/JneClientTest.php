<?php

namespace Nextlogique\Jnt\Tests\Unit;

use Nextlogique\Jnt\Http\Client;
use Nextlogique\Jnt\Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class JntClientTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('jnt.api', [
            'username' => 'jnt-api-username',
            'key' => 'jnt-api-key',
            'url' => 'http://jnt-api-url',
        ]);
    }

    /** @test */
    public function it_can_instantiate_the_jnt_client_correctly()
    {
        $jnt = $this->app->make(Client::class);

        $this->assertInstanceOf(Client::class, $jnt);
        $this->assertEquals('jnt-api-username', $jnt->getUsername());
        $this->assertEquals('jnt-api-key', $jnt->getApiKey());
    }
}
