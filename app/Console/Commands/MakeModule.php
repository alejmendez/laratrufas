<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modules:make {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->argument('module');
        $directories = [
            "Modules/{$module}/Http/Controllers",
            "Modules/{$module}/Http/Resources",
            "Modules/{$module}/Http/Requests",
            "Modules/{$module}/Models",
            "Modules/{$module}/Resources/Components",
            "Modules/{$module}/Resources/Pages",
            "Modules/{$module}/Routes",
            "Modules/{$module}/Services",
            "Modules/{$module}/Database/Migrations",
            "Modules/{$module}/Database/Seeders",
        ];

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
                $this->info("Directorio creado: {$directory}");
            }
        }

        // Crear archivos base
        $files = [
            "Modules/{$module}/Routes/web.php" => "<?php\n\nuse Illuminate\Support\Facades\Route;\n",
            "Modules/{$module}/Routes/api.php" => "<?php\n\nuse Illuminate\Support\Facades\Route;\n",
            "Modules/{$module}/Database/Seeders/{$module}Seeder.php" => "<?php\n\nnamespace Modules\\{$module}\\Database\\Seeders;\n\nuse Illuminate\Database\Seeder;\n\nclass {$module}Seeder extends Seeder\n{\n    public function run()\n    {\n        //\n    }\n}",
            "Modules/{$module}/Resources/Pages/Index.vue" => "<script setup>\n</script>\n\n<template>\n</template>",
            "Modules/{$module}/Resources/Pages/Create.vue" => "<script setup>\n</script>\n\n<template>\n</template>",
            "Modules/{$module}/Resources/Pages/Edit.vue" => "<script setup>\n</script>\n\n<template>\n</template>",
            "Modules/{$module}/Resources/Components/Form.vue" => "<script setup>\n</script>\n\n<template>\n</template>",
        ];

        foreach ($files as $path => $content) {
            if (!file_exists($path)) {
                file_put_contents($path, $content);
                $this->info("Archivo creado: {$path}");
            }
        }
    }
}
