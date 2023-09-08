<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */
$has_social_menu = has_nav_menu( 'social' );
?>
<footer id="site-footer" role="contentinfo" class="header-footer-group">
			<div class="container">
				<div class="row footerPadding">
					
				<div class="col-md-4 col-sm-12">
					<?php
					if(is_active_sidebar('sidebar-1')){
					dynamic_sidebar('sidebar-1');
					}
					?>
				</div>
					
				<div class="col-md-4 col-sm-12">
					<div class="footer2colT">
					<?php
					if(is_active_sidebar('sidebar-2')){
					dynamic_sidebar('sidebar-2');
					}
					?>
					</div>
					<div class="footer2colS ">
					<?php if ( $has_social_menu ) { ?>

						<nav aria-label="<?php esc_attr_e( 'Social links', 'twentytwenty' ); ?>" class="footer-social-wrapper">

							<ul class="social-menu footer-social reset-list-style social-icons fill-children-current-color">

								<?php
								wp_nav_menu(
									array(
										'theme_location'  => 'social',
										'container'       => '',
										'container_class' => '',
										'items_wrap'      => '%3$s',
										'menu_id'         => '',
										'menu_class'      => '',
										'depth'           => 1,
										'link_before'     => '<span class="screen-reader-text">',
										'link_after'      => '</span>',
										'fallback_cb'     => '',
									)
								);
								?>

							</ul><!-- .footer-social -->

						</nav><!-- .footer-social-wrapper -->
							</div>
					<?php } ?>


				</div>
					
					<div class="col-md-4 col-sm-12">
					
					<?php
					if(is_active_sidebar('sidebar-3')){
					dynamic_sidebar('sidebar-3');
					}
					?>
					
					</div>
				</div>
</div>

<div class="section-inner"> 
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12 text-left">
						<p class="footer-copyright">Bonuspedia.pl All Rights Reserved &copy;
							<?php
							echo date_i18n(
								/* translators: Copyright date format, see https://secure.php.net/date */
								_x( 'Y', 'copyright date format', 'twentytwenty' )
							);
							?>
						</p><!-- .footer-copyright -->
			</div>
			<div class="col-md-8 col-sm-8 col-xs-12">
				<ul class="nav nav-footer nav-pills text-right">
				<?php
						if ( has_nav_menu( 'footer' ) ) 
										wp_nav_menu(
											array(
												'container'  => '',
												'items_wrap' => '%3$s',
												'theme_location' => 'footer',
											)
										);
				?>
				</ul>
			</div>
		</div>
	</div>
</div>

</div><!-- .section-inner -->
</footer><!-- #site-footer -->
<?php wp_footer(); ?>

<!-- modals -->
<!-- Modal -->
<div class="modal fade" id="bonusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<div class="content">
			<?php echo do_shortcode('[global_variable variable_name="BONUSMODAL"]');?>
		</div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="kodyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<div class="content">
			<?php echo do_shortcode('[global_variable variable_name="KODYMODAL"]');?>
		</div>
      </div>
    </div>
  </div>
</div>



</body>
</html>
