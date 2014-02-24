<?php /*

Wyatt Theme
-----------

footer.php

Footer template file	

*/

?>
				</div> <!-- close #wrapper -->
				<footer id="site-footer">
					<div class="grid">

						<?php get_sidebar('footer'); ?>
						
						<div class="full center">
							<div class="lined">
								<nav id="footer-nav" role="navigation">
									<h2 class="assistive-text">Footer menu</h2>
									<?php
										$menu_args = array(
											'theme_location' => 'footer',
											'container' => false,
											'menu_class' => 'menu',
										);
									?>
									<?php wp_nav_menu($menu_args); ?>
								</nav>
								<p>&copy; <?php echo date('Y'); ?> All rights reserved.</p>
							</div>
						</div>
					</div>
				</footer>
				
				<div id="page_overlay"><!-- blackout div for the page --></div>

			</div> <!-- close #page -->
		</div> <!-- close #control -->

		<script src="http://bible.logos.com/jsapi/referencetagging.js" type="text/javascript"></script>
		<script type="text/javascript">
			Logos.ReferenceTagging.lbsBibleVersion = "ESV";
			Logos.ReferenceTagging.lbsLogosLinkIcon = "dark";
			Logos.ReferenceTagging.lbsNoSearchTagNames = [ "h2", "h3", "h3" ];
			Logos.ReferenceTagging.lbsTargetSite = "biblia";
			Logos.ReferenceTagging.lbsCssOverride = true;
			Logos.ReferenceTagging.tag();
		</script>

		<?php wp_footer(); ?>

	</body>
</html>