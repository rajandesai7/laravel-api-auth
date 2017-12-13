<?php namespace Rlogical\ApiAuth;

/**
 * This class is the main entry point of api-auth. Usually the interaction
 * with this class will be done through the Api Auth Facade
 *
 * @license MIT
 * @package Rlogical\ApiAuth
 */

class ApiAuth
{
    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new confide instance.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Checks if the current token is valid
     *
     * @param string $token Token.
     *
     * @return bool
     */
    public function validateToken($token)
    {
        if ($user = $this->user()) {
            //return $user->hasRole($role);
        }
        return false;
    }

    /**
     * Get the currently authenticated user or null.
     *
     * @return Illuminate\Auth\UserInterface|null
     */
    public function user()
    {
        return $this->app->auth->user();
    }
}
