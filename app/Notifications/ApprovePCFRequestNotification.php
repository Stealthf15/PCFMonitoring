<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ApprovePCFRequestNotification extends Notification
{
    use Queueable;

    private $salesAsst, $acct, $institution, $supplier, $psr, $nsm, $cfo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($salesAsst, $acct, $institution, $supplier, $psr, $nsm , $cfo)
    {
        $this->salesAsst = $salesAsst;
        $this->acct = $acct;
        $this->institution = $institution;
        $this->supplier = $supplier;
        $this->psr = $psr;
        $this->nsm = $nsm;
        $this->cfo = $cfo;
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
                    ->cc($this->salesAsst)
                    ->subject('PCF Request Status')
                    ->greeting(new HtmlString('<center>Heads up, PCF-RFQ has been approved</center>'))
                    ->line(new HtmlString('Just letting you know that ' . $this->acct . ' has copied you on <q>PCF NO._' . $this->institution . '_' . $this->supplier . '_'.$this->psr.'</q>
                    to inform you that your request for Quotation has been approved by Ma\'am ' . $this->nsm .'/NSM and Ma\'am ' . $this->cfo .'/CFO.'))
                    ->line(new HtmlString('<strong>Thank you!</strong>'));
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
