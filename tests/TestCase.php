<?php

namespace Vkovic\LaravelEventLog\Test;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Vkovic\LaravelEventLog\EventLogServiceProvider;
use function Vkovic\LaravelEventLog\package_path;

class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Load package migrations
        $this->artisan('migrate');

        $this->loadMigrationsFrom(package_path('tests/database/migrations'));

        $this->loadFactoriesUsing($this->app, package_path('tests/database/factories'));
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            EventLogServiceProvider::class
        ];
    }

    /**
     * Define environment setup
     *
     * @param Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // While testing, force use of test Events namespace
        config()->set('event-log.events', 'Vkovic\LaravelEventLog\Test\Support\Events\*');

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }
}