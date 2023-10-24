<?php

namespace ikepu_tp\LaravelVersioning\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DeployCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is a package for some commands to do when deploying.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("executing deploying...");
        $cmds = [
            "config:cache",
            "route:cache",
            "view:cache",
            "queue:restart",
            "event:cache",
            "schedule:clear-cache",
            "migrate --force",
        ];
        $progressBar = $this->output->createProgressBar(count($cmds));
        foreach ($cmds as $key => $cmd) {
            Artisan::call($cmd);
            $progressBar->advance();
        }
        $progressBar->finish();
        $this->info("\n All commands done.");
    }
}
