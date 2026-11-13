<?php

namespace ProcessMaker\Package\DemoDos\Console\Commands;

use Illuminate\Console\Command;

class Uninstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo-dos:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall Demo Dos Package';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Demo Dos package Uninstalled');
    }
}
