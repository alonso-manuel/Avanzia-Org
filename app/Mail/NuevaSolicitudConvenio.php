<?php

namespace App\Mail;

use App\Models\SolicitudConvenio;
use App\Support\OpcionesConvenio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevaSolicitudConvenio extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public SolicitudConvenio $solicitud) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Nueva solicitud de convenio: {$this->solicitud->institucion}",
            replyTo: [new Address($this->solicitud->correo, $this->solicitud->representante)],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.nueva-solicitud-convenio',
            with: [
                'tipo' => OpcionesConvenio::TIPOS_INSTITUCION[$this->solicitud->tipo_institucion] ?? $this->solicitud->tipo_institucion,
                'interes' => OpcionesConvenio::INTERESES[$this->solicitud->interes] ?? $this->solicitud->interes,
            ],
        );
    }
}
