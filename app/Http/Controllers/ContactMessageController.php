<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
	public function post(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email',
			'message' => 'required'
		]);

		Mail::raw($request->message, function ($message) use ($request) {
			$message->from($request->email, $request->name);

			$message->to('hello@bluemarket.com')->subject('Contact Us - BlueMarket');
		});

		if (Mail::failures()) {
			return ['status' => 'error'];
		}

		return ['status' => 'success'];
	}
}
