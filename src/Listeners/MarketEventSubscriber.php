<?php
 
namespace Pondol\Market\Listeners;
 
use Pondol\Market\Events\OrderShipped;
use Illuminate\Support\Facades\Notification;
use Pondol\Market\Notifications\OrderShippedNotification;
class MarketEventSubscriber
{

  public function __construct() // MailService $mailSvc
  {
    // $this->mailSvc = $mailSvc;
  }
  
    // /**
    //  * Handle user login events.
    //  */
    // public function handleUserLogin($event) {}
 
    // /**
    //  * Handle user logout events.
    //  */
    // public function handleUserLogout($event) {}


    public function ordered($event) {
      $event->user->notify(new OrderShippedNotification($event->user, $event->order));
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