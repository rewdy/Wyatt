<?php /*

Readium Theme
-------------

functions.php

Functions file	

*/

// Enable post thumbnails
add_theme_support('post-thumbnails');

// Add some image sizes for post thumbnails
add_image_size('page-header', 1600, 700, true);

// Add menus
if (function_exists('register_nav_menu')) {
	register_nav_menu('primary', 'Main Menu');
	register_nav_menu('footer', 'Footer Menu');
}

// Add widget areas
function wyatt_widget_init() {
	// Register footer widgets
	register_sidebar(
		array(
			'name' => __('Footer'),
			'desc' => __('Place widgets in the site footer. These look best in multiples of two (2, 4, etc).'),
			'id' => 'footer-widgets',
			'before_widget' => '<div id="%1$s" class="g2 widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2><div class="lined">'
		)
	);
}
add_action('widgets_init', 'wyatt_widget_init');

// function to return the feature image
function wyatt_featured_image() {
	$image = array();

	if (get_the_post_thumbnail() != '') {
		// get the URL of the featured image
		$header_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'page-header');
		$image['url'] = $header_image[0];
		$image['width'] = $header_image[1];
		$image['height'] = $header_image[2];
	}

	return (!empty($image)) ? $image : false;
}

// Content width
if (!isset($content_width)) {
	$content_width = 568;
}

// Add automatic feed links
add_theme_support('automatic-feed-links');

// adding fuction to get the author posts link (the only built-in function echos it).
if (!function_exists('get_author_posts_link')) {
	// must be called from within the loop
	function get_author_posts_link() {
		$the_author = get_the_author();
		$author_url = get_author_posts_url(get_the_author_meta('ID'));
		return '<a href="' . $author_url . '">' . $the_author . '</a>';
	}
}

// Custom comment output
function wyatt_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);
		$args['avatar_size'] = 32;
		$args['reply_text'] = '<i class="fa fa-comments-o"></i><span class="text">'.__('Reply').'</span>';
?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?>>

			<article class="comment">

				<?php if ($comment->comment_approved == '0') : ?>
				<p class="comment-awaiting-moderation box-help"><?php _e('Your comment is awaiting moderation.') ?></p>
				<?php endif; ?>

				<?php comment_text() ?>

				<!-- Comment details -->
				<div class="details">
					<span class="comment-date"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()); ?></a></span> &ndash;
					<span class="comment-author vcard"><?php printf(__('<span class="says">Posted by</span> <cite class="fn">%s</cite>'), get_comment_author_link()) ?></span>
					<!-- <span class="avatar"><?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?></span> -->
				</div>

				<!-- Comment links -->
				<div class="links">
					<ul class="link-list">
						<li><?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></li>
						<li><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>" title="Permalink"><i class="fa fa-link"></i><span class="text">
							Comment permalink</span></a></li>
						<?php edit_comment_link('<i class="fa fa-pencil"></i><span class="text">Edit</span>','<li>','</li>'); ?>
					</ul>
				</div>

			</article>
		</li>
<?php
}

/**
 * The default Wordpress comment form
 * leaves a lot to be desired. Here is
 * a version that has more markup and is
 * easier to style.
 */
function wyatt_comment_form() {
	// define fields
	$fields = array(
		'author' => '<p class="form-item label-inline comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		'<span class="input-holder"><input id="author" name="author" type="text" class="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></span></p>',
		'email'  => '<p class="form-item label-inline comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		'<span class="input-holder"><input id="email" name="email" type="text" class="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></span></p>',
		'url'	=> '<p class="form-item label-inline comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
		'<span class="input-holder"><input id="url" name="url" type="text" class="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span></p>',
	);
	
	// build our new defaults array (based off of default defaults. customized values noted.
	$defaults = array(
		'fields'			=> apply_filters('comment_form_default_fields', $fields ), /* customized */
		'comment_field'		=> '<p class="form-item label-inline comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><span class="input-holder"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></span></p>', /* customized */
		'must_log_in'			=> '<p class="must-log-in help">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'			=> '<p class="logged-in-as help">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before'	=> '<p class="comment-notes help">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'	=> '<p class="some-html-allowed help small">' . sprintf(__('Some <abbr title="Hyper Text Markup Language">HTML</abbr> allowed: <code>%s</code>'), allowed_tags()) . '</p>', /* customized */
		'id_form'				=> 'commentform',
		'id_submit'				=> 'submit',
		'title_reply'			=> __( 'Leave a Comment' ),
		'title_reply_to'		=> __( 'Leave a Reply to %s' ),
		'cancel_reply_link'		=> __( 'Cancel Comment' ),
		'label_submit'			=> __( 'Post Comment' )
	);
	
	// send them back out! Bam!
	return $defaults;
}

add_filter('comment_form_defaults', 'wyatt_comment_form');

/**
 * Functions available in templates
*/
// Function(s) to generate a list of links for sharing
function get_share_links($url, $title, $class = 'sharing-list', $icon_prefix = 'fa fa-') {
	if (isset($url) && isset($title)) {
		$url = urlencode($url);
		$title = urlencode($title);

		$services['facebook'] = array(
			'label' => 'Facebook',
			'url'	=> 'http://www.facebook.com/sharer.php?s=100&amp;p[title]={{title}}&amp;p[url]={{url}}',
			'icon'	=> 'facebook',
		);
		$services['twitter'] = array(
			'label' => 'Twitter',
			'url'	=> 'https://twitter.com/intent/tweet?url={{url}}&amp;text={{title}}',
			'icon'	=> 'twitter',
		);
		$services['pinterest'] = array(
			'label'	=> 'Pinterest',
			'url'	=> 'http://www.pinterest.com/pin/create/bookmarklet/?url={{url}}&description={{title}}',
			'icon'	=> 'pinterest',
		);
		// $services['tumblr'] = array(
		// 	'label'	=> 'Tumblr',
		// 	'url'	=> 'http://www.tumblr.com/share/?url={{url}}&description={{title}}',
		// 	'icon'	=> 'tumblr',
		// );
		$services['gplus'] = array(
			'label'	=> 'Google +',
			'url'	=> 'https://plus.google.com/share?url={{url}}',
			'icon'	=> 'google-plus',
		);
		$services['email']	= array(
			'label'	=> 'Email',
			'url'	=> 'mailto:?&amp;Subject=Sharing:+{{title}}&amp;Body={{url}}',
			'icon'	=> 'envelope',
			'extra' => 'target="_blank"',
		);

		// build the output
		$output = '<ul class="' . $class . '">' . "\n";
		foreach ($services as $key => $service) {
			$extra = (isset($service['extra'])) ? ' '.$service['extra'] : '';
			$output .= "\t" . '<li><a href="'.$service[url].'" class="'.$key.'"'.$extra.'><i class="{{icon_prefix}}'.$service[icon].'"></i> <span class="text">'.$service[label].'</span></a></li>' . "\n";
		}
		$output .= '</ul>';

		$output = preg_replace('/{{url}}/', $url, $output);
		$output = preg_replace('/{{title}}/', $title, $output);
		$output = preg_replace('/{{icon_prefix}}/', $icon_prefix, $output);

		return $output;
	} else {
		// not enought data. return empty string.
		return '';
	}
}
function share_links($url, $title, $class = 'sharing-list', $icon_prefix = 'fa fa-') {
	echo get_share_links($url, $title, $class, $icon_prefix);
}