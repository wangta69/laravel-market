<?php
 
namespace App\Listeners;
 
use App\Events\OrderShipped;
use Illuminate\Support\Facades\Notification;
// use App\Services\Market\MailService;
use App\Notifications\OrderShippedNotification;
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
      \Log::info('ordered =====================================');
    // \Log::info(json_encode($event));
    // \Log::info(json_encode($event->user));
    // \Log::info(json_encode($event->order));
    // \Log::info('event end =====================================');
      $event->user->notify(new OrderShippedNotification($event->user, $event->order));
      // Notification::send($event->user, new OrderShippedNotification);
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