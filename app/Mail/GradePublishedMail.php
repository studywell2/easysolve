<?php

namespace App\Mail;

use App\Models\Grade;
use App\Models\Term;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GradePublishedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Grade $grade,
        public Term $term,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Grade Published: ' . $this->grade->subject->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.grade-published',
        );
    }
}