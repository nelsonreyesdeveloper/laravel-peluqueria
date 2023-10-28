<?php

namespace App\Notifications;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;

class EmailNewCitaUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $cita;
    public function __construct($cita)
    {
        $this->cita = $cita;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $fecha =  Carbon::parse($this->cita->fecha_cita)->locale('es')->isoFormat('D [de] MMMM [de] YYYY');

        $serviciosLines = [];

        foreach ($this->cita->servicios as $servicio) {
            $servicioLine = $servicio->nombre . ' cantidad: ' . $servicio->pivot->cantidad . ' subtotal: $' . $servicio->pivot->subtotal;
            $serviciosLines[] = $servicioLine;
        }

        $message = (new MailMessage)
            ->subject('Acabas de registrar una nueva cita.')
            ->line('Tienes una cita pendiente ' . Str::title($this->cita->user->name) . '.')
            ->line('Fecha: ' . $fecha . ' Hora: ' . $this->cita->hora_cita)
            ->line('Los servicios son:');

        foreach ($serviciosLines as $servicioLine) {
            $message->line($servicioLine);
        }

        return $message->line('El monto total de la cita es: $' . $this->cita->total);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
