<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{

	public function post(Request $request) {
		$this->validate(
			$request, [
				'name' => 'required',
				'email' => 'required|email',
				'message' => 'required'
			]
		);

		// sanitizing input
		$name = filter_var($request->name, FILTER_SANITIZE_STRING);
		$email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
		$body = filter_var($request->message, FILTER_SANITIZE_STRING);

		Mail::raw(
			$body, function ($message) use ($request) {
				$message->from($request->email, $request->name);
				$message->to('hello@bluemarket.com')->subject('Contact Us - BlueMarket');
			}
		);

		if (Mail::failures()) {
			return ['status' => 'error'];
		}

		return ['status' => 'success'];
	}

}
