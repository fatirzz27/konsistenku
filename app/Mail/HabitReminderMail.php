<?php

namespace App\Mail;

use App\Models\Habit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HabitReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Habit $habit
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Reminder: Waktunya {$this->habit->name}!",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.habit-reminder',
        );
    }
}