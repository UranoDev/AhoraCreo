<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendBookPdf extends Mailable
{
    use Queueable, SerializesModels;

    public string $downloadUrl;

    public function __construct(public Subscriber $subscriber)
    {
        $this->downloadUrl = route('subscriber.download', [
            'subscriber' => $subscriber->id,
            'token' => hash('sha256', $subscriber->email),
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Here is your free book!'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.send-book',
        );
    }

    public function attachments(): array
    {
        $pdfPath = self::getPdfPath();

        if (file_exists($pdfPath)) {
            return [
                Attachment::fromPath($pdfPath)
                    ->as(config('book.pdf_filename'))
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }

    public static function getPdfPath(): string
    {
        return storage_path('app/' . config('book.pdf_directory') . '/' . config('book.pdf_filename'));
    }
}
