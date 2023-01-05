<?php

namespace App\Notifications\Sistema\Aovivo;

use App\Models\Agendamentoaovivo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AulaNaoExecutada extends Notification
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
        return (new MailMessage)
            ->subject('GUITARPEDIA - Aula não executada!')
            ->greeting('Olá ' . $notifiable->nome)
            ->line('O aluno **' . $this->agendamento->aluno->fullName . '** acabou de informar que a aula **' . $this->agendamento->aula->categoria->nome . '**, do professor **' . $this->agendamento->professor->fullName . '**, 
                agendada para **' . dateBdToApp($this->agendamento->data) . ' às ' . $this->agendamento->inicio . '**, NÃO OCORREU!')
            ->line('O motivo alegado pelo aluno foi:')
            ->line('**"' . $this->agendamento->avaliacao->comentario_aluno . '"**')
            ->line('')
            ->line('Por favor, realize a moderação da mesma.')
            ->action('Painel administrativo', route('sistema.index'));
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
