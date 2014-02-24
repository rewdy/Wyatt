<?php /*

Wyatt Theme
-----------

index.php

Main template file	

*/

?>

<?php get_header(); ?>
					<div id="content-body">
						<div class="grid">
							<?php
								$classes = array();
								if (!is_singular()) {
									array_push($classes, 'listing');
								}
							?>
							<div class="full <?php echo implode(' ', $classes); ?>">
								
							<?php if (have_posts()) : ?>

							<?php if (is_archive()) get_template_part('partials/archive-heading'); ?>

								<?php /* Start the Loop */ ?>
								<?php while (have_posts()) : the_post(); ?>

								<?php get_template_part('partials/content', get_post_type()); ?>

								<?php endwhile; ?>

								<?php if (!is_singular()) : ?>

								<div class="directional-links pagination">
									<?php if (get_next_posts_link() != '') :?>
									<div class="nav-previous"><?php next_posts_link('<i class="fa fa-angle-left"></i> <span class="text">Older posts</span>'); ?></div>
									<?php endif; ?>
									<?php if (get_previous_posts_link() != '') :?>
									<div class="nav-next"><?php previous_posts_link('<span class="text">Newer posts</span> <i class="fa fa-angle-right"></i>'); ?></div>
									<?php endif; ?>
								</div>

								<?php endif; ?>
	
							<?php else : ?>

								<article id="post-0" class="post no-results not-found">
									<h2>Nothing Found</h2>

									<p>I'm sorry, but no results were found. Perhaps searching will help find a related post.</p>

									<?php get_search_form(); ?>
									
								</article>

							<?php endif; ?>

							</div>
						</div>

					</div> <!-- close #content-body -->

					<?php comments_template(); ?>

<?php get_footer(); ?>