<?php

namespace App\Notifications\Aovivo;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PagamentoOkNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $url = route('sistema.alunos.index');

        return (new MailMessage)
          ->subject('GUITARPEDIA - Pedido aprovado!')
          ->line('Olá **' . $notifiable->fullName . '**!')
          ->line('O pagamento do seu pedido no Guitarpedia foi **APROVADO!**!')
          ->line('Agradecemos a confiança em nosso trabalho e a possibilidade de trabalharmos juntos rumo ao seu objetivo!')
          ->line('Acesse o link abaixo e faça seu login, para agendar as suas aulas, entrando no menu "Ao Vivo -> Agendar aulas pagas".')
          ->action('Agendar Aulas', $url);
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
