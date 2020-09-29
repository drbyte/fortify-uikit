<?php

namespace Zacksmash\FortifyUIkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FortifyUIkitCommand extends Command
{
    public $signature = 'fortify-ui:uikit';

    public $description = 'Install UIkit preset, with views and resources';

    public function handle()
    {
        $this->publishAssets();
        $this->updateWebpackUrl();

        $this->comment('UIkit is now installed.');
        $this->info('Remember to run npm i && npm run dev!');
    }

    protected function publishAssets()
    {
        $this->callSilent('vendor:publish', ['--tag' => 'resources', '--force' => true]);

        File::deleteDirectory(resource_path('css'));
    }

    protected function updateWebpackUrl()
    {
        File::put(
            base_path('webpack.mix.js'),
            str_replace(
                'http://CHANGE_ME.test',
                env('APP_URL'),
                File::get(base_path('webpack.mix.js'))
            )
        );
    }
}
