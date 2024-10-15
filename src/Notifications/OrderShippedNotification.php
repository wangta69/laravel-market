<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Services\Market\OrderService;
// 
class OrderShippedNotification extends Notification  implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  protected $user, $order;

  public function __construct($user, $order) // OrderService $ordergSvc
  {
    \Log::info('__construct OrderShippedNotification');
    $this->user = $user;
    $this->order = $order;
    // $this->orderSvc = $ordergSvc;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {

    \Log::info('toMail OrderShippedNotification');
    // \Log::info('toMail  11 =====================================');
    // \Log::info($notifiable);
    // \Log::info('this->order:'.$this->order);
    // \Log::info('endnotifiable =====================================');
    $orderSvc = new OrderService;
    $data = new \stdClass;
    $data->items = $orderSvc->orderItemsByOrderid($this->order)->orderBy('market_orders.id', 'desc')->get();     
    $data->display = $orderSvc->orderDetailByOrderid($this->order);

    $user = $this->user;
    // \Log::info('display data start =====================================');
    // \Log::info(json_encode($data));
    // \Log::info(json_encode($this->user));
    // \Log::info(json_encode('market.templates.mail.'.config('market.template.mail.theme').'.order'));
    // \Log::info('end =====================================');
    return (new MailMessage)
      ->subject($user->name.'님의 주문정보입니다.')
      ->markdown('market.templates.mail.'.config('market.template.mail.theme').'.order', [
        'user' => $this->user,
        'data' => $data
      ]);

    // return (new MailMessage)->subject($notifiable->name.'님의 주문정보입니다.')
    //   ->view('market.templates.mail.'.config('market.template.mail.theme').'.order')
    //   ->with([
    //     'user' => $user,
    //     'data' => $data
    //   ]);

  }

  /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }


}
