// searchFunction.js
import _debounce from 'lodash.debounce';


class FuzzySearch {
	constructor(nameInput, tagInput, domClass, collection, tagName) {
		this.collection = collection;
		this.domClass = domClass;
		this.$nameInput = $(nameInput);
		this.$tagInput = $(tagInput);
		this.$cards = $(domClass);
		this.tagName = tagName;

		this.bindEventHandlers();

		// flatten out the object:
		this.collection.forEach((item, index) => {
			item.name = item.name.toLowerCase();
			item.domid = index;
			item[this.tagName] = item[this.tagName].map(tag => {
				return tag.name;
			});
		});
	}

	bindEventHandlers() {
		// Attach event handlers
		this.$nameInput.on('keyup', {fzs: this}, _debounce(this.filterItems, 200));
		this.$tagInput.on('change', {fzs: this}, this.filterItems);
	}

	filterItems(event) {
		const self = event.data.fzs;
		const nameQuery = self.$nameInput.val().trim().toLowerCase();

		// get all the projects where name LIKE %namequery%:
		let results = self.collection.filter(item => {
			return item.name.indexOf(nameQuery) > -1; //indexOf returns position of first occurence
		});

		console.log(results);
		// get the projects that match search tags:
		const finalResults = self.filterProjectsByTags(results);

		self.$cards.hide();

		// no projects found
		if(finalResults.length == 0) {
			$('.noProjectsMessage').show();
		}

		// show found projects
		$('.noProjectsMessage').hide();

		finalResults.forEach(result => {
			self.$cards.eq(result.domid).show();
		});
	}

	filterProjectsByTags(results) {
		const tagQuery = this.$tagInput.val(); // Returns an array for the select

		return results.filter(item => {
			return tagQuery.every(query => {
				return item[this.tagName].indexOf(query) > -1;
			});
		});

	}
}

window.FuzzySearch = FuzzySearch;
