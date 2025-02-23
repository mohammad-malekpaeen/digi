<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set {--db_host=} {--db_user=}  {--db_pass=} {--db_new_database_name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Assign Value To Env';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbname = $this->option('db_new_database_name');
        $dbHost = $this->option('db_host');
        $dbUser = $this->option('db_user');
        $dbPass = $this->option('db_pass');

        $this->setEnv('DB_HOST', $dbHost);
        $this->setEnv('DB_USERNAME', $dbUser);
        $this->setEnv('DB_PASSWORD', $dbPass);
        $this->setEnv('DB_DATABASE', $dbname);
    }

    public function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name.'='.env($name),
                $name.'='.$value,
                file_get_contents($path)
            ));
        }
    }
}
