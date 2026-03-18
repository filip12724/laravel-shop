<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('shop.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:20|max:2000',
        ]);

        $contact = ContactMessage::create($validated);

        try {
            Mail::to(config('mail.admin_address', config('mail.from.address')))->send(new ContactMail($contact));
        } catch (\Exception $e) {
            // Log but don't fail — message is saved in DB
        }

        return redirect()->route('contact')->with('success', 'Your message has been sent! We will get back to you soon.');
    }
}
