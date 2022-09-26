<header id="masthead" class="site-header">
	<div class="visible-menu">
		<div id="hamburger-container" class="hamburger-container">
		  <svg xmlns="http://www.w3.org/2000/svg" width="58" height="58" viewBox="0 0 200 200">
		        <g stroke-width="6.5" stroke-linecap="round">
		          <path
		            d="M72 82.286h28.75"
		            fill="#009100"
		            fill-rule="evenodd"
		            stroke="#fff"
		          />
		          <path
		            d="M100.75 103.714l72.482-.143c.043 39.398-32.284 71.434-72.16 71.434-39.878 0-72.204-32.036-72.204-71.554"
		            fill="none"
		            stroke="#fff"
		          />
		          <path
		            d="M72 125.143h28.75"
		            fill="#009100"
		            fill-rule="evenodd"
		            stroke="#fff"
		          />
		          <path
		            d="M100.75 103.714l-71.908-.143c.026-39.638 32.352-71.674 72.23-71.674 39.876 0 72.203 32.036 72.203 71.554"
		            fill="none"
		            stroke="#fff"
		          />
		          <path
		            d="M100.75 82.286h28.75"
		            fill="#009100"
		            fill-rule="evenodd"
		            stroke="#fff"
		          />
		          <path
		            d="M100.75 125.143h28.75"
		            fill="#009100"
		            fill-rule="evenodd"
		            stroke="#fff"
		          />
		        </g>
		      </svg>
		</div>
		<a class="site-branding" href="<?php echo get_site_url(); ?>">
			<img src="/wp-content/themes/pe-theme-child/images/logo.svg" class="logo" height="" alt="Logo naam bedrijf" height="56" width="56">
		</a>
		
		<a href="#">
			<img src="/wp-content/themes/pe-theme-child/images/whatsapp.svg" alt="whatsapp icon" height="56" width="56">
		</a>
	</div>	
	<div class="overlay-menu">
		<div class="overlay-left">
			<nav id="site-navigation" class="main-navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav>	
		</div>
		<div class="overlay-right">
			<div class="overlay-right-wrapper"></div>	
		</div>		
		<div class="overlay-background"></div>		
	</div>

</header>