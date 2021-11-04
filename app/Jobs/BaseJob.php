<?php

namespace HDSSolutions\Laravel\Jobs;

use HDSSolutions\Laravel\Http\Middleware\SettingsLoader;
use HDSSolutions\Laravel\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MichaelLedin\LaravelJob\Job;

abstract class BaseJob extends Job {

    protected $user;
    protected Company $company;

    public function middleware() {
        return [ new SettingsLoader ];
    }

    public function __construct() {
        // save user that dispatched the job
        $this->user = auth()->user()?->fresh();
        // save company where we are working
        $this->company = backend()->company()?->fresh();
    }

    protected final function notify(string $eventClass, ...$params) {
        // dispatch notification event
        forward_static_call_array([ $eventClass, 'dispatch' ], array_merge([ $this->user ], $params));
    }

    public final function handle() {
        // register company
        backend()->setCompany( $this->company );
        // execute Job process
        $this->execute();
    }

    protected abstract function execute();

}
