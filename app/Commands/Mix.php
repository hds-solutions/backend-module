<?php

namespace HDSSolutions\Laravel\Commands;

use Symfony\Component\Process\Process;

class Mix extends \Illuminate\Console\Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backend:mix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile assets for backend module';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        (new Process([
            'npm', 'run', 'dev',
            '--mix-config', backend_path('webpack.mix.js'),
        ], backend_path()))->run(function($type, $buffer) {
            dump($buffer);
        });
    }

}
