<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {resource} {tableName?}';
    // EXAMPLE:
    // php artisan make:crud category categories


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CRUD using DynaCore.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the name of the new controller and category folder from the user input.
        $resource = $this->argument('resource');
        $tableName = $this->argument('tableName');  // used to create and migrate new table in DB

        // Create the new controller and category folder.
        $this->makeCrud($resource);

        if ($tableName != null) {
            Artisan::call('make:migration', ['name' => 'create_' . $tableName . '_table']);
        }


        // Display a success message.
        $this->info('New ' . $resource . ' CRUD created successfully.');
    }


    public function makeCrud(string $resource): void
    {

        /////////////////////////////////////////////////////////////////////////////
        ////// Controller
        /////////////////////////////////////////////////////////////////////////////
        // Copy the CoreController file to the new controller file.
        $process1 = Process::run('cp App/Core/CoreStubs/CoreController.php App/Http/Controllers/Dashboard/' . $this->toClassName($resource) . 'Controller.php');

        // Replace the CoreController class name with the new class name.
        if ($process1->successful()) {
            $fileContents = file_get_contents('App/Http/Controllers/Dashboard/' . $this->toClassName($resource) . 'Controller' . '.php');
            $fileContents = str_replace('CoreController', $this->toClassName($resource) . 'Controller', $fileContents);
            $fileContents = str_replace('namespace App\Core\CoreStubs', 'namespace App\Http\Controllers\Dashboard', $fileContents);
            file_put_contents('App/Http/Controllers/Dashboard/' . $this->toClassName($resource) . 'Controller' . '.php', $fileContents);
        }

        /////////////////////////////////////////////////////////////////////////////
        ////// Resource
        /////////////////////////////////////////////////////////////////////////////
        $process2 = Process::run('cp App/Core/CoreStubs/CoreResource.php App/Http/Resources/' . $this->toClassName($resource) . 'Resource.php');

        // Replace the CoreResource class name with the new class name.
        if ($process2->successful()) {
            $fileContents = file_get_contents('App/Http/Resources/' . $this->toClassName($resource) . 'Resource' . '.php');
            $fileContents = str_replace('CoreResource', $this->toClassName($resource) . 'Resource', $fileContents);
            $fileContents = str_replace('namespace App\Core\CoreStubs', 'namespace App\Http\Resources', $fileContents);
            file_put_contents('App/Http/Resources/' . $this->toClassName($resource) . 'Resource' . '.php', $fileContents);
        }

        /////////////////////////////////////////////////////////////////////////////
        ////// Request
        /////////////////////////////////////////////////////////////////////////////
        $process3 = Process::run('cp App/Core/CoreStubs/CoreRequest.php App/Http/Requests/' . $this->toClassName($resource) . 'Request.php');

        // Replace the CoreRequest class name with the new class name.
        if ($process3->successful()) {
            $fileContents = file_get_contents('App/Http/Requests/' . $this->toClassName($resource) . 'Request' . '.php');
            $fileContents = str_replace('CoreRequest', $this->toClassName($resource) . 'Request', $fileContents);
            $fileContents = str_replace('namespace App\Core\CoreStubs', 'namespace App\Http\Requests', $fileContents);
            file_put_contents('App/Http/Requests/' . $this->toClassName($resource) . 'Request' . '.php', $fileContents);
        }

        /////////////////////////////////////////////////////////////////////////////
        ////// Model
        /////////////////////////////////////////////////////////////////////////////
        $process4 = Process::run('cp App/Core/CoreStubs/CoreModel.php App/Models/' . $this->toClassName($resource) . '.php');

        // Replace the CoreModel class name with the new class name.
        if ($process4->successful()) {
            $fileContents = file_get_contents('App/Models/' . $this->toClassName($resource) . '.php');
            $fileContents = str_replace('CoreModel', $this->toClassName($resource), $fileContents);
            $fileContents = str_replace('namespace App\Core\CoreStubs', 'namespace App\Models', $fileContents);
            file_put_contents('App/Models/' . $this->toClassName($resource) . '.php', $fileContents);
        }


        /////////////////////////////////////////////////////////////////////////////
        ////// Views
        /////////////////////////////////////////////////////////////////////////////
        $process5 = Process::run('cp -r App/Core/CoreStubs/core-blade resources/views/dashboard/' . $resource);


        /////////////////////////////////////////////////////////////////////////////
        ////// add items to sidebar_items.php
        /////////////////////////////////////////////////////////////////////////////
        $process6 = $this->add_sidebar_item($resource);

        /////////////////////////////////////////////////////////////////////////////
        ////// generate routes in web.php
        /////////////////////////////////////////////////////////////////////////////
        $process7 = $this->generate_web_routes($resource);

        /////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////
    }














    public function add_sidebar_item($resource)
    {
        $filePath = config_path('sidebar_items.php');
        $existingContent = file_get_contents($filePath);

        $newArray = "[
            'menu_title' => '" . $this->toClassName($resource, false) . "',
            'menu_title_icon' => '',
            'active' => 'dashboard." . $resource . ".*',
            'permission' => '" . $resource . "',
            'menu_title_list' => [
                [
                    'route' => 'dashboard." . $resource . ".index',
                    'label' => '" . $this->toClassName($resource, false) . "',
                    'active' => 'dashboard." . $resource . ".index',
                    'permission' => 'index-list-" . $resource . "',
                ],
                [
                    'route' => 'dashboard." . $resource . ".create',
                    'label' => 'Create " . $this->toClassName($resource, false) . "',
                    'active' => 'dashboard." . $resource . ".create',
                    'permission' => 'create-" . $resource . "',
                ],
            ],
        ],";

        $lastBracketPosition = strrpos($existingContent, ']');

        if ($lastBracketPosition !== false) {
            // Insert the new array after the last ']' in the content.
            $updatedContent = substr_replace($existingContent, "\n" . $newArray, $lastBracketPosition, 0);
            // $updatedContent = substr_replace($existingContent, $newArray, $lastBracketPosition, 0);


            // Write the updated content back to the file.
            file_put_contents($filePath, $updatedContent);

            // Output a success message.
            $this->info('New array added to sidebar_items.php successfully.');
        } else {
            // Handle the case where ']' was not found.
            $this->error('Error: Could not find the last array in sidebar_items.php || or you forget to add , at the end of the last array.');
        }
    }



    public function generate_web_routes($resource)
    {
        // Read the content of routes/web.php
        $filePath = base_path('routes/web.php');
        $webContent = file_get_contents($filePath);

        // Define the new route you want to add
        // $newRoute = "Route::resource('" . $resource . "', " . $this->toClassName($resource) . "Controller::class);";
        $newRoute = "Route::resourceRoutes('" . $resource . "', " . $this->toClassName($resource) . "Controller::class, function (\$controller) {
            Route::post('/" . $resource . "/update/{id}', [" . $this->toClassName($resource) . "Controller::class, 'update'])->name('" . $resource . ".update');
            Route::get('/" . $resource . "-datatable/list', [" . $this->toClassName($resource) . "Controller::class, 'getDatatableIndex'])->name('" . $resource . ".datatable');
            Route::get('/" . $resource . "-trash-datatable/list', [" . $this->toClassName($resource) . "Controller::class, 'getDatatableTrash'])->name('" . $resource . ".trash-datatable');
        });";


        // Search for the last occurrence of '});' in the content
        $lastClosingBracketPosition = strrpos($webContent, '});');

        if ($lastClosingBracketPosition !== false) {
            // Calculate the position to insert the new route
            $insertPosition = $lastClosingBracketPosition;

            // Ensure a newline before and after the new route
            if ($webContent[$insertPosition - 1] !== "\n") {
                $newRoute = "\n" . $newRoute;
            }
            if ($webContent[$insertPosition + 2] !== "\n") {
                $newRoute .= "\n";
            }


            // Insert the new route before the last '});'
            $updatedWebContent = substr_replace($webContent, $newRoute, $insertPosition, 0);

            // Write the updated content back to the file
            file_put_contents($filePath, $updatedWebContent);

            // Output a success message
            $this->info('New route added to routes/web.php successfully.');
        } else {
            // Handle the case where '});' was not found
            $this->error('Error: Could not find the last closing bracket in routes/web.php.');
        }
    }



    public function toClassName(string $string, $className = true): string
    {
        $string = str_replace('_', ' ', $string);
        $string = ucwords($string);
        if ($className == true) // if true => (ClassName) | if false => (Class Name)
            $string = str_replace(' ', '', $string);

        return $string;
    }
}
