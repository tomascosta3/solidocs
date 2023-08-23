<?php

namespace App\Mail;

use App\Models\Login;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $verification_link;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Login $login,
        protected User $user
    )
    {
        $this->verification_link = route('auth.verify', ['token' => $login->verification_code]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verificación de cuenta',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.auth.account_verification',
            with: [
                'verification_code' => $this->login->verification_code,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'verification_link' => $this->verification_link,
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
