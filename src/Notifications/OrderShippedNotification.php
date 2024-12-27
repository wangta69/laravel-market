<?php

namespace Pondol\Market\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


// 
class OrderShippedNotification extends Notification  implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  protected $data;

  public function __construct($data)
  {
    \Log::info('__construct OrderShippedNotification');
    // $this->user = $user;
    $this->data = $data;
    // $this->toMail();
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


    return (new MailMessage)
      ->subject($notifiable->name.'님의 주문정보입니다.')
      ->markdown(market_theme('mail').'.order', [
        'user' => $notifiable,
        'data' => $this->data
      ]);

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
