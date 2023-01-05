<?php

namespace App\Notifications\Sistema\Aovivo;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Models\Agendamentoaovivo;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AulaReAgendada extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $professor;

    public function __construct(Agendamentoaovivo $agendamento)
    {
        $this->agendamento = $agendamento;
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
        $i = Carbon::createFromFormat('Y-m-d H:i:s', $this->agendamento->data . ' ' . $this->agendamento->inicio);
        $url = route('sistema.alunos.aovivo.agendar.pagas');

        return (new MailMessage)
            ->subject('GUITARPEDIA - Aula Reagendada!')
            ->greeting('Olá ' . $notifiable->nome)
            ->line('Sua aula de **' . $this->agendamento->aula->categoria->nome . '**, com o professor **' . $this->agendamento->professor->fullName . '**, 
            que ocorreria em **' . dateTimeBdToApp($i) . '**, foi **REAGENDADA** pelo professor.')
            ->line('Por favor, faça um novo agendamento em seu painel de controle')
            ->action('Acessar Painel', $url);
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
