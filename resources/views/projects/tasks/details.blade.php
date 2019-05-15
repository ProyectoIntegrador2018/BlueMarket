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
						<i class="small circle green icon"></i><p style="display:inline;">Open</p>
					</div>
				</div>
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
						<p id="task-due-date" class="task-due needs-localdatetime"></p>
					</div>
					<div class="sixteen wide column">
						<p class="task-detail-subtitle">Opened</p>
						<p><span id="task-opened-date" class="needs-localdatetime"></span> by <span id="task-opened-by"></span></p>
					</div>
					<div id="task-closed-details" class="sixteen wide column">
						<p class="task-detail-subtitle">Closed</p>
						<p><span id="task-closed-date" class="needs-localdatetime"></span> by <span id="task-closed-by"></span></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="actions">
		<button class="ui black deny button">Close</button>
		<button id="task-edit-btn" data-id="" type="submit" class="ui primary button">Edit</button>
	</div>
</div>
