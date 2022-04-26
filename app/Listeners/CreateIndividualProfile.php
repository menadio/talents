<?php

namespace App\Listeners;

use App\Events\NewIndividualRegistered;
use App\Models\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateIndividualProfile implements ShouldQueue
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'database';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 5;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewIndividualRegistered  $event
     * @return void
     */
    public function handle(NewIndividualRegistered $event)
    {
        // create newly registered user's profile
        Profile::create([
            'user_id' => $event->user->id
        ]);        
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\NewIndividualRegistered  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(NewIndividualRegistered $event, $exception)
    {
        Log::notice($exception->getMessage());
    }
}
