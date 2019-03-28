// npm install --save lodash.debounce OR yarn add lodash.debounce
import _debounce from 'lodash.debounce';

// Event handler:
$('#searchName').on('keyup', _debounce(filterProjects, 200));
$('#searchTags').on('change', filterProjects);
// Flatten out the object:
projects.forEach((project, index) => {
	project.name = project.name.toLowerCase();
	project.domid = index;
	project.tags = project.tags.map(tag => {
		return tag.name;
	});
});
// DOM Elements (<projectCard>):
const $projectCards = $('.ProjectCard-container');
function filterProjects() {
	const nameQuery = $('#searchName').val().trim().toLowerCase();
	const tagQuery = $('#searchTags').val(); // Returns an array for the select
	// Get all the projects where name LIKE %namequery%:
	let projectResults = projects.filter(project => {
		return project.name.indexOf(nameQuery) > -1;
	});
	// Get the projects that match search tags:
	const finalResults = projectResults.filter(project => {
		let matchesAllTags = true;
		for (var i = 0; i < tagQuery.length; i++) {
			if(project.tags.indexOf(tagQuery[i]) === -1) {
				matchesAllTags = false;
				break;
			}
		}
		return matchesAllTags;
	});
	$projectCards.hide();
	//When no projects where found:
	if(finalResults.length == 0){
		$('.noProjectsMessage').show();
	}
	//When projects where found:
	finalResults.forEach(project => {
		$('.noProjectsMessage').hide();
		$projectCards.eq(project.domid).show();
	});
}
