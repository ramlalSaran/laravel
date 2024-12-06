<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;



class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Order Confirmation', // Customize the subject here
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'e-commerce.profile.invoice', // The view you want to use
        );
    }

    public function build()
    {
        return $this->view('e-commerce.profile.invoice')
                    ->with(['order' => $this->order]);
    }
}

