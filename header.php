<?php /*

Wyatt Theme
-----------

header.php

Header template file	

*/

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="<?php bloginfo('charset'); ?>" />

		<title><?php (wp_title('', false) != '') ? wp_title('&#8226;', true, 'right') : ''; ?><?php bloginfo('name'); ?></title>

		<!-- Meta -->
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="theme-color" content="#2976ea">
		
		<!-- Links -->
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<!-- Stylesheets -->
		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<?php
		// Stylesheets
		wp_enqueue_style('lato', '//brick.a.ssl.fastly.net/Lato:100,400,700,400i,700i');
		wp_enqueue_style('wyatt', get_stylesheet_uri(), 'lato');
		
		// Javascript

		// pull in the jQuery
		wp_enqueue_script('jquery');
		if (is_singular()) {
			// pull in Nivo-gallery
			wp_enqueue_script('nivo-lightbox', get_template_directory_uri() . '/lib/Nivo-Lightbox-1.1/nivo-lightbox.min.js', 'jquery', 1.0);
		}
		// pull in the site js
		wp_enqueue_script('wyatt_js', get_template_directory_uri() . '/js/wyatt-script.js', 'jquery', false);

		// comment script
		if (is_singular() && get_option('thread_comments')) :
			wp_enqueue_script('comment-reply');
		endif;
		?>

		<?php 
		// Wordpress header content

		wp_head(); ?>

	</head>
	<body<?php echo (is_admin_bar_showing()) ? ' class="admin-bar"' : ''; ?>>

		<div id="control">
			
			<?php // get_template_part('drawer'); ?>

			<div id="page">
				<div id="wrapper">
					<header id="site-header">
						<div class="grid">
							<div class="full">
								<?php $title_tag = (!is_single()) ? 'h1' : 'div'; ?>
								<<?php echo $title_tag; ?> id="site-title"><a href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></<?php echo $title_tag; ?>>
								<?php // insert tagline? ?>
							</div>
						</div>
					</header>
					<div id="nav-holder">
						<div class="grid">
							<div class="full">
								<nav id="access" role="navigation">
									<a href="#menu" id="menu-link"><i class="fa fa-bars"></i></a>
									<h2 class="assistive-text">Main menu</h2>
									<?php
										$menu_args = array(
											'theme_location' => 'primary',
											'container' => false,
											'menu_class' => 'menu',
										);
									?>
									<?php wp_nav_menu($menu_args); ?>
								</nav>
							</div>
						</div>
					</div>
					