<?php /*

Wyatt Theme
-----------

article.php

Article default template file	

* Called from within the loop. Will not work otherwise. *

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	$featured_image = wyatt_featured_image();
	if ($featured_image) :
	?>
	<div class="featured-image">
		<img src="<?php echo $featured_image['url']; ?>" width="<?php echo $featured_image['width']; ?>" height="<?php echo $featured_image['height']; ?>" />
	</div>
	<?php endif; ?>

	<!-- Post Title -->
	<?php if (!is_singular()) :?>
	<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php else: ?>
	<h1><?php the_title(); ?></h1>
	<?php endif;?>

	<p class="date"><?php the_time(get_option('date_format')); ?></p>

	<!-- Post Content -->
	<?php if (!is_singular()) : ?>
	<?php the_excerpt(); ?>
	<?php else : ?>
	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<div class="page-links">' . __('Pages') . ':', 'after' => '</div>')); ?>
	<?php endif; ?>

	<!-- Post taxonomy -->
	<?php $categories_list = get_the_category_list(', '); ?>
	<?php $tags_list = get_the_tag_list('', ', '); ?>
	
	<?php if ($categories_list) : ?>
	<div class="details">Posted in <?php echo $categories_list; ?></div>
	<?php endif; ?>

	<!-- Post links -->
	<div class="links">
		<ul class="link-list">
			<?php if (!is_singular()) : ?>
			<li><a href="<?php the_permalink(); ?>" title="<?php _e('Read more...'); ?>" class="perma-link"><i class="fa fa-ellipsis-h"></i><span class="text"><?php _e('Permalink'); ?></span></a></li>
			<?php endif; ?>
			<?php if (comments_open()) : ?>
			<?php $comment_icon = '<i class="fa fa-comment"></i>'; ?>
			<li><?php comments_popup_link($comment_icon . '<span class="text">Comment</span>', $comment_icon . '<span class="text">1 Comment</span>', $comment_icon . '<span class="text">% Comments</span>'); ?></li>
			<?php endif; ?>
			<?php edit_post_link('<i class="fa fa-pencil"></i><span class="text">Edit</span>', '<li>', '</li>' ); ?>
		</ul>
	</div>

	<?php if (is_singular()) : ?>
	<div class="sharing">
		<div class="sharing-heading">Share</div>
		<?php share_links(get_permalink(), get_the_title()); ?>
	</div>
	<?php endif; ?>

	<div class="readline"><!-- Indcator for how much of the article has been read --></div>

</article>

<?php if (is_single()) : ?>
<div class="directional-links horizontal">
	<div class="nav-previous"><?php previous_post_link('%link', '<i class="fa fa-angle-left"></i> <span class="text">&#8220;%title&#8221;</span>'); ?></div>
	<div class="nav-next"><?php next_post_link('%link', '<span class="text">&#8220;%title&#8221;</span> <i class="fa fa-angle-right"></i>'); ?></div>
</div>
<?php endif; ?>
