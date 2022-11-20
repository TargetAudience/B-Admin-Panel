<div class="header-wrap">
	<div class="left-align"><span class="label-top-page-name">{$pageTitle}<span></span></span></div>
	<div class="right-align">
		<div class="name-role-wrap">
			<div class="name">{$session.firstName} {$session.lastName}</div>
		</div>
		<button class="dropdown-button" id="js__click-user-dropdown-menu">
			<div class="inner">
				<svg class="arrow-svg" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<path fill="inherit" d="M14.1711599,9.3535 L9.99925636,13.529 L5.82735283,9.3535 C5.51262415,9.0385 5.73543207,8.5 6.18054835,8.5 L13.8179644,8.5 C14.2630807,8.5 14.4858886,9.0385 14.1711599,9.3535"></path>
				</svg>
				<div class="icon-wrap">
					<svg viewBox="0 0 250 250" xmlns="http://www.w3.org/2000/svg">
						<g fill="inherit">
							<path d="M146.8 142.6h-37.6c-31.1 0-56.5 25.3-56.5 56.5 0 5.2 4.2 9.4 9.4 9.4h131.8c5.2 0 9.4-4.2 9.4-9.4 0-31.2-25.3-56.5-56.5-56.5zM128 130.7c20.1 0 36.4-16.3 36.4-36.4v-9.4c0-20.1-16.3-36.4-36.4-36.4S91.6 64.8 91.6 84.9v9.4c0 20.1 16.3 36.4 36.4 36.4z"></path>
						</g>
					</svg>
				</div>
			</div>
		</button>
	</div>
</div>

<div class="top-user-menu" role="menu" tabindex="-1" id="js__user-dropdown-menu">
	<a class="user-button" href="{$URL}profile">
		<svg class="svg-icon profile" viewBox="0 0 250 250" xmlns="http://www.w3.org/2000/svg">
			<g fill="inherit">
				<path d="M146.8 142.6h-37.6c-31.1 0-56.5 25.3-56.5 56.5 0 5.2 4.2 9.4 9.4 9.4h131.8c5.2 0 9.4-4.2 9.4-9.4 0-31.2-25.3-56.5-56.5-56.5zM128 130.7c20.1 0 36.4-16.3 36.4-36.4v-9.4c0-20.1-16.3-36.4-36.4-36.4S91.6 64.8 91.6 84.9v9.4c0 20.1 16.3 36.4 36.4 36.4z"></path>
			</g>
		</svg>
		<div class="text">My Profile</div>
	</a>
	<a class="user-button" href="{$URL}user/signout">
		<svg class="svg-icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
			<g fill="inherit">
				<path d="M15,2 L5,2 C4.447,2 4,2.447 4,3 L4,9 L9.586,9 L8.293,7.707 C7.902,7.316 7.902,6.684 8.293,6.293 C8.684,5.902 9.316,5.902 9.707,6.293 L12.707,9.293 C13.098,9.684 13.098,10.316 12.707,10.707 L9.707,13.707 C9.512,13.902 9.256,14 9,14 C8.744,14 8.488,13.902 8.293,13.707 C7.902,13.316 7.902,12.684 8.293,12.293 L9.586,11 L4,11 L4,17 C4,17.553 4.447,18 5,18 L15,18 C15.553,18 16,17.553 16,17 L16,3 C16,2.447 15.553,2 15,2"></path>
			</g>
		</svg>
		<div class="text">Sign Out</div>
	</a>
</div>
