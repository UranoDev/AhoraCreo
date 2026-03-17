<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function subscribers(): View
    {
        $subscribers = Subscriber::orderedByStatus()
            ->paginate(50);

        $stats = [
            'total' => Subscriber::count(),
            'verified' => Subscriber::whereNotNull('email_verified_at')->count(),
            'pdf_sent' => Subscriber::where('pdf_sent', true)->count(),
            'downloaded' => Subscriber::where('pdf_downloaded', true)->count(),
            'pending' => Subscriber::whereNull('email_verified_at')->count(),
        ];

        return view('admin.subscribers', compact('subscribers', 'stats'));
    }
}