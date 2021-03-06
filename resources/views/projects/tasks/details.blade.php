<div id="task-details-modal" class="ui modal task-details-modal">
	<div class="scrolling content">
		<!-- title -->
		<div id="task-details" class="ui stackable grid task-details">
			<div class="ten wide column">
				<div class="row">
					<h1 id="task-title"></h1>
				</div>
			</div>
			<div class="six wide column">
				<div class = "ui stackable grid">
					<div id="task-status" class="eight wide column" style="padding: 0;">
						<i></i><p style="display:inline;"></p>
					</div>
				</div>
			</div>
			<div class="sixteen wide column">
				<p id="assigned-to">Assigned to: <a id="task-assignee" href=""></a><span id="assignee-no-one">no one</span></p>
			</div>
			<div class="ten wide column">
				<div class="row">
					<div class="sixteen wide column">
						<p class="task-detail-subtitle">Description</p>
						<p id="task-description"></p>
					</div>
				</div>
			</div>
			<div class="six wide column">
				<div class="ui stackable grid">
					<div class="sixteen wide column">
						<p class="task-detail-subtitle">Due</p>
						<p id="task-due-date" class="task-due task-datetime"></p>
					</div>
					<div class="sixteen wide column">
						<p class="task-detail-subtitle">Opened</p>
						<p><span id="task-opened-date" class="task-datetime"></span> by <a id="task-opened-by" href=""></a></p>
					</div>
					<div id="task-closed-details" class="sixteen wide column">
						<p class="task-detail-subtitle">Closed</p>
						<p><span id="task-closed-date" class="task-datetime"></span> by <a id="task-closed-by" href=""></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="actions">
		<button class="ui black deny button">Close</button>
		<button id="task-edit-btn" type="submit" class="ui primary button">Edit</button>
	</div>
</div>
