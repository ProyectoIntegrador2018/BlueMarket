<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	protected $guarded = [];

	public function leader() {
		return $this->belongsTo('App\User', 'leader_id');
	}
}
