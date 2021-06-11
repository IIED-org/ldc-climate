<?php
/**
 * Header-1 template.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       http://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="fusion-header-sticky-height"></div>
<div class="fusion-header">
	<div class="fusion-row">
		<div class="top_menu_sec">
			<ul>
				<li><a href="<?php echo home_url(); ?>/login">Login</a></li>
			</ul>
		</div>
		<?php if ( 'flyout' === Avada()->settings->get( 'mobile_menu_design' ) ) : ?>
		<div class="fusion-header-has-flyout-menu-content">
		<?php endif; ?>
		<?php avada_logo(); ?>
		<?php //avada_main_menu(); ?>
		<nav class="fusion-main-menu" aria-label="Main Menu" style="display: block;">
		
		<?php
		$defaults = array(
			'theme_location'  => 'main_navigation',
		'menu'            => '',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		);
		wp_nav_menu( $defaults );
		?>
		
		</nav>
		<?php if ( 'flyout' === Avada()->settings->get( 'mobile_menu_design' ) ) : ?>
			</div>
		<?php endif; ?>
	</div>
</div>
