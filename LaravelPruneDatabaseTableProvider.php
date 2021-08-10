<?php

namespace Lex10000\LaravelPruneDatabaseTable;

use Illuminate\Support\ServiceProvider;
use Lex10000\LaravelPruneDatabaseTable\Console\PruneTable;

class LaravelPruneDatabaseTableProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->registerPublishing();
        $this->mergeConfigFrom(__DIR__ . '/config/prune-table.php', 'prune-table');
    }

    /**
     * Register the package's commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    PruneTable::class
                ]
            );
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/config/prune-table.php' => config_path('prune-table.php'),
                ],
                'prune-table-config'
            );
        }
    }
}
