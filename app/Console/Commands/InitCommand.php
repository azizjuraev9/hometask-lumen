<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 02.02.2023
 * Time: 12:52
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;

class InitCommand extends Command
{

    public function handle()
    {
        $dbname = env('DB_DATABASE');
        $query = 'SELECT 'CREATE DATABASE mydb' WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'mydb')';
    }

}
