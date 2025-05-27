<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class in app/Services';

    public function handle()
    {
        $name = $this->argument('name');
        $serviceName = ucfirst($name) . 'Service';
        $directory = app_path('Services');
        $path = $directory . '/' . $serviceName . '.php';

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($path)) {
            $this->error('Service already exists!');
            return;
        }

        $stub = "<?php

namespace App\Services;

class {$serviceName}
{
    //
}
";

        File::put($path, $stub);
        $this->info("Service {$serviceName} created successfully.");
    }
}
