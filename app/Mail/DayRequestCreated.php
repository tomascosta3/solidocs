<?php

namespace App\Mail;

use App\Models\Day;
use App\Models\DayRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DayRequestCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $request_link;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected User $user,
        protected DayRequest $day_request,
        protected User $request_user
    )
    {
        $this->request_link = route('home');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->day_request->day->type . ' de ' . $this->request_user->first_name . ' ' . $this->request_user->last_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.requests.created',
            with: [
                'request_link' => $this->request_link,
                'user' => $this->user,
                'day_request' => $this->day_request,
                'request_user' => $this->request_user,
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
