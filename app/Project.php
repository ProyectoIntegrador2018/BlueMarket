<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $guarded = [];
	public function tags()
	{
		return $this->belongsToMany('App\Tag');
	}
}
