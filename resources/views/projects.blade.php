
@extends('layouts.app')

@section('title', 'Projects')

@section('content')
@section('header', 'Projects')
<div class="ui four stackable cards">
	@for ($i = 0; $i < 10; $i++)
		@projectCard(['projectImage' => 'https://source.unsplash.com/400x300/?project', 'projectName' => 'A cool project', 'category' => 'Videogames', 'projectShortDescription' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'skillset' => ['Skill 0', 'Skill 1', 'Skill 2'], 'publicMilestone' => 'shipping'])
		@endprojectCard
    @endfor
</div>
@endsection
