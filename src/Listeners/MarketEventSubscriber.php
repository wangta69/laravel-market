<?php
 
namespace App\Listeners;
 
use App\Events\OrderShipped;

use App\Http\Controllers\Market\Services\MailService;

class MarketEventSubscriber
{

  public function __construct(MailService $mailSvc)
  {
    $this->mailSvc = $mailSvc;
  }
  
    // /**
    //  * Handle user login events.
    //  */
    // public function handleUserLogin($event) {}
 
    // /**
    //  * Handle user logout events.
    //  */
    // public function handleUserLogout($event) {}


    public function ordered(OrderShipped $event) {
      // $params = new \stdClass;
      // $params->o_id = $event->order;
      // $params->type = 'order';
      // $this->mailSvc->orderMail($event->user, $params);
    }
 
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
      return [
        OrderShipped::class => 'ordered',
      ];
    }
}