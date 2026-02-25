<?php

namespace App\Http\Controllers;

use App\Models\ContactMe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

//        dd($contact->contact_user_name);
        Mail::raw(
            "New contact message\n\nName: {$contact->contact_user_}\nEmail: {$contact->contact_user_email}\nMessage:\n{$contact->contact_user_message}",
            function ($mail) use ($contact) {
                $mail->to('atuoisreal3@email.com')
                    ->subject('New Contact Message');
            }
        );

        Mail::raw(
            "Hi {$contact->contact_user_name}, we received your message. We will get back to you soon.",
            function ($mail) use ($contact) {
                $mail->to($contact->contact_user_email)
                    ->subject('Message Received');
            }
        );
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
        //
    }
}
