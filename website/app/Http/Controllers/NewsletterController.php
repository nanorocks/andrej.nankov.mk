<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $request->validate(['email' => 'required|email|unique:subscribers']);
        Subscriber::create(['email' => $request->email]);
        return back()->with('success', 'Subscribed successfully!');
    }
}
