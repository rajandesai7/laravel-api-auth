<?php namespace Rlogical\ApiAuth;

/**
 * This file is a part of Api Auth,
 * api authentication management solution for Laravel.
 *
 * @license MIT
 * @package Rlogical\ApiAuth
 */

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class MigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'api-auth:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the api-auth specifications.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->laravel->view->addNamespace('api-auth', substr(__DIR__, 0, -8).'views');

        $tokensTable = Config::get('api-auth.tokens_table');

        $this->line('');
        $this->info( "Tables: $tokensTable" );

        $message = "A migration that creates '$tokensTable'".
        " tables will be created in database/migrations directory";

        $this->comment($message);
        $this->line('');

        if ($this->confirm("Proceed with the migration creation? [Yes|no]", "Yes")) {

            $this->line('');

            $this->info("Creating migration...");
            if ($this->createMigration($tokensTable)) {

                $this->info("Migration successfully created!");
            } else {
                $this->error(
                    "Couldn't create migration.\n Check the write permissions".
                    " within the database/migrations directory."
                );
            }
            $this->line('');
        }
    }

    /**
     * Create the migration.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function createMigration($tokensTable)
    {
        $migrationFile = base_path("/database/migrations")."/".date('Y_m_d_His')."_api_auth_setup_tables.php";

        $userModel = Config::get('auth.providers.users.model');
        $userModel = new $userModel;
        $userKeyName = $userModel->getKeyName();
        $usersTable  = $userModel->getTable();

        $data = compact('tokensTable', 'usersTable', 'userKeyName');

        $output = $this->laravel->view->make('api-auth::generators.migration')->with($data)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }
}
