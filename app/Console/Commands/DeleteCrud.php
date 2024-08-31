<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteCrud extends Command
{
    protected $signature = 'delete:crud {resource} {table}';
    protected $description = 'Delete CRUD files (Controller, Resource, Request, Model, Views) and routes for the specified resource and table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $resource = ucfirst($this->argument('resource'));
        $table = $this->argument('table');

        // Paths to the CRUD files
        $paths = [
            app_path("Http/Controllers/Dashboard/{$resource}Controller.php"),
            app_path("Http/Resources/{$resource}Resource.php"),
            app_path("Http/Requests/{$resource}Request.php"),
            app_path("Models/{$resource}.php"),
            resource_path("views/dashboard/{$resource}"),
        ];
        $migrationFiles = $this->getMigrationFiles($table);
        $paths = array_merge($paths, $migrationFiles);
        // Delete CRUD files
        foreach ($paths as $path) {
            if (File::exists($path)) {
                if (File::isDirectory($path)) {
                    File::deleteDirectory($path);
                    $this->info("Directory '{$path}' has been deleted.");
                } else {
                    File::delete($path);
                    $this->info("File '{$path}' has been deleted.");
                }
            } else {
                $this->warn("File or directory '{$path}' does not exist.");
            }
        }

        $this->info("CRUD files and routes for resource '{$resource}' and table '{$table}' have been deleted.");
        $this->warn("Remove the Routes from web.php & Item from sidebar_items");
    }

    protected function getMigrationFiles($table)
    {
        $migrationPath = database_path('migrations');
        $files = File::files($migrationPath);

        $migrationFiles = [];

        foreach ($files as $file) {
            if (strpos($file->getFilename(), "_{$table}_") !== false) {
                $migrationFiles[] = $file->getRealPath();
            }
        }

        return $migrationFiles;
    }
}
