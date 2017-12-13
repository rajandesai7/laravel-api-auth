<?php namespace Rlogical\ApiAuth;

/**
 * This file is a part of Api Auth,
 * api authentication management solution for Laravel.
 *
 * @license MIT
 * @package Rlogical\ApiAuth
 */

use Illuminate\Support\ServiceProvider;

class ApiAuthServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('api-auth.php'),
        ]);

        // Register commands
        $this->commands('command.api-auth.migration');

        // Register blade directives
        $this->bladeDirectives();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerApiAuth();

        $this->registerCommands();

        $this->mergeConfig();
    }

    /**
     * Register the blade directives
     *
     * @return void
     */
    private function bladeDirectives()
    {
        // Call to ApiAuth::validateToken()
        \Blade::directive('token', function($expression) {
            return "<?php if (\\ApiAuth::validateToken({$expression})) : ?>";
        });
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerApiAuth()
    {
        $this->app->bind('api-auth', function ($app) {
            return new ApiAuth($app);
        });

        $this->app->alias('api-auth', 'Rlogical\ApiAuth\ApiAuth');
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        $this->app->singleton('command.api-auth.migration', function ($app) {
            return new MigrationCommand();
        });
    }

    /**
     * Merges user's and api-auth's configs.
     *
     * @return void
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'api-auth'
        );
    }

    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.api-auth.migration'
        ];
    }
}
