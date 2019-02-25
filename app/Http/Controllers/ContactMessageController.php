<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email',
			'message' => 'required'
		]);

		Mail::raw($request->message, function($message) use($request)
		{
			$message->from($request->email, $request->name);

			$message->to('katiarriaga@gmail.com')->subject('Contact Us - BlueMarket');
		});

		return redirect()->back()->with('flash_message', 'Thank you for your message.');
	}
}
