<div class="wrapper_page">
	<header>
	   <div class="inner-nav">
	        <nav>
	            <a class="logo-container" href="javascript:;"><img src="{$URL_ASSETS}/images/logo@2x.png" /></a>
	            <div class="header-container" id="js__avatar-parent">
	                <a id="js__avatar-link">
	                    <div class="avatar-sm">
	                        <div class="avatar-initials">{$session.firstInitial}{$session.lastInitial}</div>
	                    </div>
	                    <span class="icon2-arrow arrow"></span>
	                </a>
	                <div class="popover avatar">
	                    <div class="person-details first">
	                        <div>{$session['firstName']} {$session['lastName']}</div>
	                        <div>{$session['emailAddress']}</div>
	                    </div>
	                    <div class="link-section second">
	                        <a href="{$URL}myaccount">My account</a>
	                        <a href="{$URL}user/signout">Sign out</a>
	                    </div>
	                </div>
	            </div>
	        </nav>
	    </div>
	</header>