<?php

namespace App\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Events\Dispatcher;

use App\Events\Registered;
use App\Http\Controllers\Market\Services\MailService;

class SendRegisteredNotification implements ShouldQueue
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(MailService $mailSvc)
  {
    $this->mailSvc = $mailSvc;
  }

  /**
   * Handle the event.
   *
   * @param  \App\Events\Registered  $event
   * @return void
   */
  public function handle(Registered $event)
  {

    $this->mailSvc->registerMail($event->user);
    //
  }


}
