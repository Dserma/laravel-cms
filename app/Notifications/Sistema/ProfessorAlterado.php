<?php

namespace App\Notifications\Sistema;

use App\Models\Professoraovivo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfessorAlterado extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $professor;

    public function __construct(Professoraovivo $professoraovivo)
    {
        $this->professor = $professoraovivo;
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
            ->subject('GUITARPEDIA - Alteração de cadastro de Professor')
            ->greeting('Olá ' . $notifiable->nome)
            ->line('O professor **' . $this->professor->fullName . '** acabou de realizar uma alteração em seu cadastro!')
            ->line('Por favor, dê uma olhada em sua página para validar essas informações.')
            ->action('Página do professor', route('sistema.aluno.aovivo.professor', $this->professor->slug));
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
