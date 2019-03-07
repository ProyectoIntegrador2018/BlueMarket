<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
	/**
	* Bootstrap any application services.
	*
	* @return void
	*/
	public function boot()
	{
		// Aliasing components
		Blade::component('components.projectCard', 'projectCard');
	}

	/**
	* Register any application services.
	*
	* @return void
	*/
	public function register()
	{
		//
	}
}
