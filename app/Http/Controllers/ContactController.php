<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactNotificationMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the contact page with contact form and contact details.
     */
    public function index()
    {
        $contactInfo = [
            'name' => 'Rohit Verma',
            'role' => 'Full Stack Web Developer (Laravel / PHP)',
            'email' => 'rohitv3319@gmail.com',
            'phone' => '+91 6378156855',
            'whatsapp' => '6378156855',
            'location' => 'Rajasthan, India',
            'availability' => 'Available for Full-time Roles & High-Impact Freelance Projects',
        ];

        return view('pages.contact', compact('contactInfo'));
    }

    /**
     * Handle the submission of the contact form.
     */
    public function store(ContactRequest $request)
    {
        try {
            // Save contact inquiry in database
            $contact = Contact::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
                'ip_address' => $request->ip(),
                'is_read' => false,
            ]);

            // Determine recipient email (defaulting to Rohit Verma's official email)
            $recipient = config('mail.contact_recipient', 'rohitv3319@gmail.com');

            // Dispatch notification email
            try {
                Mail::to($recipient)->send(new ContactNotificationMail($contact));
            } catch (\Exception $mailEx) {
                // Log the mail error safely without disrupting user experience if mail server is unconfigured
                Log::warning('Contact notification email could not be delivered: ' . $mailEx->getMessage(), [
                    'contact_id' => $contact->id,
                ]);
            }

            return redirect()
                ->route('contact')
                ->with('success', 'Thank you, ' . e($contact->name) . '! Your message has been safely received. Rohit will get back to you within 24 hours.');

        } catch (\Exception $e) {
            Log::error('Error processing contact form submission: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Sorry, there was an unexpected issue saving your message. Please reach out directly to rohitv3319@gmail.com or call +91 6378156855.');
        }
    }
}
