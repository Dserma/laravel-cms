<?php

namespace App\Notifications\Sistema\Aovivo;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Models\Agendamentoaovivo;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AulaAgendadaProfessor extends Notification
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
        $f = Carbon::createFromFormat('Y-m-d H:i:s', $this->agendamento->data . ' ' . $this->agendamento->fim);
        $url = 'https://www.google.com/calendar/render?action=TEMPLATE&text=Aula+de+' . $this->agendamento->aula->categoria->nome . '+-+Professor+' . $this->agendamento->professor->fullName;
        $url .= '&details=Aula+de+' . $this->agendamento->aula->categoria->nome . '%2C+com+o+ALuno+' . $this->agendamento->aluno->fullName . '%2C+das+' . $this->agendamento->inicio . '+%C3%A0s+' . $this->agendamento->fim;
        $url .= '%2C+na+plataforma+Guitarpedia&location=Guitarpedia+%28+https%3A%2F%2Fguitarpedia.com.br+%29&dates=' . $i->format('Ymd\THis') . '%2F' . $f->format('Ymd\THis');

        return (new MailMessage)
            ->subject('GUITARPEDIA - Aula agendada!')
            ->greeting('Olá ' . $notifiable->nome)
            ->line('Sua aula de **' . $this->agendamento->aula->categoria->nome . '**, com o aluno **' . $this->agendamento->aluno->fullName . '**, 
                foi agendada para **' . dateBdToApp($this->agendamento->data) . ' às ' . $this->agendamento->inicio . '**')
            ->line('')
            ->line('Você pode adicionar esse agendamento ao seu Google Calendar, clicando no botão abaixo:')
            ->action('Adicionar ao Google Calendar', $url);
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
