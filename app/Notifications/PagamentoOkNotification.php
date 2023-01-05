<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Repositories\Sistema\BaseRepository;
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
        $texto = BaseRepository::getTexto('email_pagamento_ok', $notifiable, 'nome');

        return (new MailMessage)
          ->subject('GUITARPEDIA - Confirmação de pagamento de assinatura')
          ->line($texto)
          ->action('Painel do Aluno', $url);
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
