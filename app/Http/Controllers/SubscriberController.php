<?php

namespace App\Http\Controllers;

use App\Mail\SendBookPdf;
use App\Mail\VerifySubscriberEmail;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SubscriberController extends Controller
{
    public function landing(): View
    {
        return view('landing');
    }

    public function subscribe(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $existing = Subscriber::where('email', $validated['email'])->first();

        if ($existing) {
            if ($existing->isVerified()) {
                return back()->with('info', __('This email has already been verified. Check your inbox for the book.'));
            }

            // Resend verification email
            $token = Subscriber::generateVerificationToken();
            $existing->update(['verification_token' => $token]);
            Mail::to($existing->email)->send(new VerifySubscriberEmail($existing));

            return back()->with('success', __('A new verification link has been sent to your email.'));
        }

        $subscriber = Subscriber::create([
            'email' => $validated['email'],
            'verification_token' => Subscriber::generateVerificationToken(),
        ]);

        Mail::to($subscriber->email)->send(new VerifySubscriberEmail($subscriber));

        return back()->with('success', __('Please check your email to verify your address and receive the book.'));
    }

    public function verify(string $token): View|RedirectResponse
    {
        $subscriber = Subscriber::where('verification_token', $token)->first();

        if (!$subscriber) {
            return redirect()->route('landing')
                ->with('error', __('Invalid or expired verification link.'));
        }

        $subscriber->markAsVerified();

        // Send the PDF email
        Mail::to($subscriber->email)->send(new SendBookPdf($subscriber));
        $subscriber->markAsPdfSent();

        return view('subscriber.verified');
    }

    public function download(Subscriber $subscriber, string $token): BinaryFileResponse|RedirectResponse
    {
        $expectedToken = hash('sha256', $subscriber->email);

        if (!hash_equals($expectedToken, $token)) {
            return redirect()->route('landing')
                ->with('error', __('Invalid download link.'));
        }

        $pdfPath = SendBookPdf::getPdfPath();

        if (!file_exists($pdfPath)) {
            return redirect()->route('landing')
                ->with('error', __('The book file is not available at this time.'));
        }

        $subscriber->markAsPdfDownloaded();

        return response()->download($pdfPath, config('book.pdf_filename'));
    }
}
