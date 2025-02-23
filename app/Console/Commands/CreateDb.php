<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class CreateDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbName = env('DB_DATABASE');
        $dbCon = env('DB_CONNECTION');
        $dbHost = env('DB_HOST');
        $dbPort = env('DB_PORT');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $query = "CREATE DATABASE IF NOT EXISTS {$dbName};";

        $pdo = new PDO("{$dbCon}:host={$dbHost}", $dbUser, $dbPass);
        $pdo->exec($query);
    }
}
