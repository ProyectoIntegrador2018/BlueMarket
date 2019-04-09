<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		// Aliasing components
		Blade::component('components.projectCard', 'projectCard');
		Blade::component('components.teams.form', 'teamsform');

		if(\App::environment('production')) {
			URL::forceScheme('https');
		}
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
