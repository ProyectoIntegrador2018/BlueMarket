// npm install --save lodash.debounce OR yarn add lodash.debounce:
import _debounce from 'lodash.debounce';
// Event handler (do something on type):
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
const $projectCards = $('.ProjectCard-container'); // Array
// projects[0] => $projectCards[0]
// Search by name, labels, or skills
// Tags => labels, skills
function filterProjects() {
	const nameQuery = $('#searchName').val().trim().toLowerCase();
	const tagQuery = $('#searchTags').val(); // Returns an array for the select
	// Get all the projects where name LIKE %namequery%:
	let projectResults = projects.filter(project => {
		return project.name.indexOf(nameQuery) > -1;
	});
	// Get the projects that match search tags:
	// All the projects where projects.tags contain all of tagQuery
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
	finalResults.forEach(project => {
		$projectCards.eq(project.domid).show();
	});
}
