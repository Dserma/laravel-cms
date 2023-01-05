<?php

namespace App\Notifications\Sistema;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContaAlterada extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $professor;

    public function __construct()
    {
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
            ->subject('GUITARPEDIA - Alteração de conta bancária')
            ->greeting('Olá ' . $notifiable->nome)
            ->line('Notamos que os seus **dados financeiros** foram alterados em nossa plataforma!')
            ->line('Para que possamos ter certeza dessa alteração, precisamos que você realize a confirmação, clicando no botão abaixo.')
            ->line('Caso não tenha sido você o autor dessa alteração, por favor, altere sua senha em nossa plataforma.')
            ->action('Confirmar Alteração', route('sistema.dash-professor.confirma-financeiro', [$notifiable->id, $notifiable->token_alteracao]));
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
