<?php

namespace App\Http\Middleware;

use Closure;
use App;

class HttpsMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (!$request->secure() && App::environment() === 'production') {
			return redirect()->secure($request->getRequestUri());
		}

		return $next($request);
	}
}
