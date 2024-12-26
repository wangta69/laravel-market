<?php
 
namespace Pondol\Market\Listeners;
 
use Pondol\Market\Events\OrderShipped;
use Illuminate\Support\Facades\Notification;
use Pondol\Market\Notifications\OrderShippedNotification;
use Pondol\Market\Services\OrderService;
use Pondol\Auth\Models\User\User;

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
      // if($event->user) { // 회원구매시, 
        // $event->user->notify(new OrderShippedNotification($event->order));
        $orderSvc = new OrderService;
        $data = new \stdClass;
        $data->items = $orderSvc->orderItemsByOrderid($event->order)->orderBy('market_orders.id', 'desc')->get();     
        $data->display = $orderSvc->orderDetailByOrderid($event->order);

        $user = User::find($data->display->user_id);
        $user->notify(new OrderShippedNotification($data));
        // new OrderShippedNotification($event->order);
      // } else { // 비회원 구매시는 어떻게 처리할 것인가?

      // }
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