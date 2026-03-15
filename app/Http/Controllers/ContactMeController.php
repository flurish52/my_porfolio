<?php

namespace App\Http\Controllers;

use App\Models\ContactMe;
use Illuminate\Http\Request;
use Resend;
class ContactMeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_user_name' => 'required|string|max:255',
            'contact_user_email' => 'required|email|max:255',
            'contact_user_message' => 'required|string',
        ]);

        $contact = ContactMe::create($data);

        $resend = Resend::client(env('RESEND_KEY'));

        $contact_user_first_name = explode(' ', trim($contact->contact_user_name))[0] ?? '';
        // Send to admin
        $resend->emails->send([
            'from' => $contact_user_first_name.'@atuoisrael.com.ng',
            'to' => ['atuoisrael3@gmail.com'],
            'reply_to' => $contact->contact_user_email,
            'subject' => 'New Contact Message',
            'text' =>
                "New contact message\n\n" .
                "Name: {$contact->contact_user_name}\n" .
                "Email: {$contact->contact_user_email}\n\n" .
                "Message:\n{$contact->contact_user_message}",
        ]);

        // Send confirmation to user
        $resend->emails->send([
            'from' => 'Israel@atuoisrael.com.ng',
            'to' => [$contact->contact_user_email],
            'subject' => 'Message Received',
            'text' =>
                "Hi {$contact->contact_user_name},\n\n" .
                "We received your message. We will get back to you soon.",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been received.'
        ], 201);
    }

        /**
     * Display the specified resource.
     */
    public function show(ContactMe $contactMe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactMe $contactMe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactMe $contactMe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMe $contactMe)
    {
        // Ensure user is authenticated
        abort_if(!auth()->check(), 401, 'Unauthenticated');

        $contactMe->delete();
    }

}
