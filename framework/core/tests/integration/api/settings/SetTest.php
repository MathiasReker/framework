<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Tests\integration\api\settings;

use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;

class SetTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->prepareDatabase([
            'users' => [
                $this->normalUser(),
            ],
        ]);
    }

    /**
     * @test
     */
    public function settings_cant_be_updated_by_user(): void
    {
        $response = $this->send(
            $this->request('POST', '/api/settings', [
                'authenticatedAs' => 2,
                'json' => [
                    'hello' => 'world',
                ],
            ])
        );

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertNotEquals('world', $this->app->getContainer()->make('flarum.settings')->get('hello'));
    }

    /**
     * @test
     */
    public function settings_can_be_updated_by_admin(): void
    {
        $response = $this->send(
            $this->request('POST', '/api/settings', [
                'authenticatedAs' => 1,
                'json' => [
                    'hello' => 'world',
                ],
            ])
        );

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals('world', $this->app->getContainer()->make('flarum.settings')->get('hello'));
    }

    /**
     * @test
     */
    public function max_setting_length_validated(): void
    {
        $response = $this->send(
            $this->request('POST', '/api/settings', [
                'authenticatedAs' => 1,
                'json' => [
                    'hello' => str_repeat('a', 66000),
                ],
            ])
        );

        $this->assertEquals(422, $response->getStatusCode());
    }
}
