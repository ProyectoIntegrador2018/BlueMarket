// npm install --save lodash.debounce OR yarn add lodash.debounce
import _debounce from 'lodash.debounce';

// event handler:
$('#searchName').on('keyup', _debounce(filterStudents, 200));
$('#searchSkills').on('change', filterStudents);

// flatten out the object:
users.forEach((user, index) => {
	user.name = user.name.toLowerCase();
	user.domid = index;
	user.skills = user.skills.map(tag => {
		return skill.name;
	});
});

// DOM Elements (<projectCard>):
const $studentCards = $('.studentCard-container');

function filterStudentsBySkills(users) {
	const skillQuery = $('#searchSkills').val(); // Returns an array for the select
	const finalResults = users.filter(user => {
		let matchesAllSkills = true;
		for (var i = 0; i < skillQuery.length; i++) {
			if(user.skills.indexOf(skillQuery[i]) === -1) {
				matchesAllSkills = false;
				break;
			}
		}
		return matchesAllSkills;
	});
	return finalResults;
}

function filterStudents() {
	const nameQuery = $('#searchName').val().trim().toLowerCase();

	// get all the projects where name LIKE %namequery%:
	let studentResults = users.filter(user => {
		return user.name.indexOf(nameQuery) > -1; //indexOf returns position of first occurence
	});

	// get the projects that match search tags:
	const finalResults = filterStudentsBySkills(studentResults);

	$studentCards.hide();

	// no projects found
	if(finalResults.length == 0){
		$('.noStudentsMessage').show();
	}

	// show found projects
	finalResults.forEach(user => {
		$('.noStudentsMessage').hide();
		$studentCards.eq(user.domid).show();
	});
}
