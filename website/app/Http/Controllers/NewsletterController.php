<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Nanorocks\DatabaseNewsletter\Facades\Newsletter;

class NewsletterController extends Controller
{
    public function showForm()
    {
        return view('newsletter');
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'cf-turnstile-response' => ['required', Rule::turnstile()],
        ]);

        $request->validate(['email' => 'required|email|unique:newsletter_subscribers,email']);

        $name = explode('@', $request->input('email'))[0] ?? 'Guest';

        Newsletter::subscribe($request->input('email'), ['name' => $name]);
        
        return back()->with('success', 'Subscribed successfully!');
    }
}
