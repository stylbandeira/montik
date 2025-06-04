<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoConfirmado extends Mailable
{
    use Queueable, SerializesModels;

    public $pre_pedido;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pre_pedido)
    {
        $this->pre_pedido = $pre_pedido;
    }

    public function build()
    {
        return $this->subject('Confirmação do seu pedido')
            ->view('emails.pedido-confirmado');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
