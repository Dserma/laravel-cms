<?php

namespace App\Notifications\Sistema\Alunos;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RespostaNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($p)
    {
        $this->p = $p;
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
            ->subject('GUITARPEDIA - Resposta da sua Pergunta')
            ->line('Olá ' . $notifiable->nome)
            ->line('Sua pergunta foi respondida pelo professor Guitarpedia!')
            ->line('Acesse aqui a aula e veja a resposta:')
            ->action('Ver Resposta', route('sistema.alunos.vod.curso.player', [$this->p->curso->slug, $this->p->modulo->slug, $this->p->aula->slug]))
            ->line('Equipe Guitarpedia');
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
