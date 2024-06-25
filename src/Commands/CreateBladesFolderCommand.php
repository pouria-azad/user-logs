<?php

namespace Binafy\LaravelUserMonitoring\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateBladesFolderCommand extends Command
{
    protected $signature = 'user_logs:create_blades';
    protected $description = 'Create folders based on the configuration';

    public function handle()
    {
        $folders = array_keys(config('user-monitoring.guards'));

        foreach ($folders as $folder) {
            $path = resource_path('views\\vendor\\laravel-user-monitoring\\authentications-monitoring\\' . $folder);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
                $this->info("Created folder: $path");
            } else {
                $this->info("Folder already exists: $path");
            }
            $path .= '\\index.blade.php';
            $currentPath = __DIR__;
            $twoLevelsUp = dirname($currentPath, 2);
            if (!File::exists($path)){
                File::copy( $twoLevelsUp.'\\resources\\views\\authentications-monitoring\\index.blade.php' , $path);
                $this->info("Created file: $path. 'index.blade.php'");
            } else {
                $this->info("File already exists:  $path. 'index.blade.php'");
            }
        }

        $this->info('All folders have been created.');
        }
}
