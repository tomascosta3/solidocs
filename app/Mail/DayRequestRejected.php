<?php

namespace App\Mail;

use App\Models\DayRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DayRequestRejected extends Mailable
{
    use Queueable, SerializesModels;

    protected $request_link;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected User $rejecter,
        protected DayRequest $day_request,
        protected User $requester
    )
    {
        $this->request_link = route('requests.view', ['id' => $day_request->id]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->rejecter->first_name . ' rechazó tu solicitud',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.requests.rejected',
            with: [
                'request_link' => $this->request_link,
                'rejecter' => $this->rejecter,
                'day_request' => $this->day_request,
                'requester' => $this->requester,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
