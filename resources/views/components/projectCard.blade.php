<div class="card bluemarket-projectcard">
    <div class="image">
        <img src={{ $projectImage }}>
    </div>
    <div class="content">
        <div class="header">{{ $projectName }}</div>
        <div class="meta">
            {{ $category }}
        </div>
        <div class="description">
            {{ $projectShortDescription }}
        </div>
    </div>
    <div class="extra content">
        <p class="ui sub header">Required skills</p>
        @foreach($skillset as $skill)
            <div class="ui bluemarket-skill label">{{ $skill }}</div>
        @endforeach
    </div>
	<div class="ui bottom attached label content">{{ $publicMilestone }}</div>
</div>
