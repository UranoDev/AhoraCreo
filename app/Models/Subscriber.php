<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'verification_token',
        'email_verified_at',
        'pdf_sent',
        'pdf_sent_at',
        'pdf_downloaded',
        'pdf_downloaded_at',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'pdf_sent_at' => 'datetime',
            'pdf_downloaded_at' => 'datetime',
            'pdf_sent' => 'boolean',
            'pdf_downloaded' => 'boolean',
        ];
    }

    public static function generateVerificationToken(): string
    {
        return Str::random(64);
    }

    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    public function markAsVerified(): void
    {
        $this->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);
    }

    public function markAsPdfSent(): void
    {
        $this->update([
            'pdf_sent' => true,
            'pdf_sent_at' => now(),
        ]);
    }

    public function markAsPdfDownloaded(): void
    {
        $this->update([
            'pdf_downloaded' => true,
            'pdf_downloaded_at' => now(),
        ]);
    }

    public function scopeOrderedByStatus($query)
    {
        return $query->orderByRaw('
            CASE
                WHEN email_verified_at IS NOT NULL AND (pdf_sent = 1 OR pdf_downloaded = 1) THEN 1
                WHEN email_verified_at IS NOT NULL THEN 2
                ELSE 3
            END ASC
        ')->orderBy('created_at', 'desc');
    }

    public function getStatusLabel(): string
    {
        if ($this->pdf_downloaded) {
            return 'downloaded';
        }
        if ($this->pdf_sent) {
            return 'pdf_sent';
        }
        if ($this->isVerified()) {
            return 'verified';
        }
        return 'pending';
    }

    public function getStatusColor(): string
    {
        return match ($this->getStatusLabel()) {
            'downloaded' => 'green',
            'pdf_sent' => 'blue',
            'verified' => 'yellow',
            'pending' => 'gray',
        };
    }
}
