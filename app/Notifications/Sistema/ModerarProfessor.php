<?php

namespace App\Notifications\Sistema;

use App\Models\Professoraovivo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModerarProfessor extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $professor;

    public function __construct(Professoraovivo $professor)
    {
        $this->professor = $professor;
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
            ->subject('GUITARPEDIA - Moderar professor')
            ->greeting('Olá ' . $notifiable->nome)
            ->line('O professor **' . $this->professor->fullName . '** acabou de cadastrar sua primeira aula!')
            ->line('Por favor, realize a moderação do mesmo.')
            ->action('Painel administrativo', route('backend.index'));
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
