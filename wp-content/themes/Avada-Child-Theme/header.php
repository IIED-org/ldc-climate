<?php
/**
 * Header template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<!DOCTYPE html>
<html class="<?php avada_the_html_class(); ?>" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/doc.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

	<?php Avada()->head->the_viewport(); ?>

	<?php wp_head(); ?>

	<?php
	/**
	 * The setting below is not sanitized.
	 * In order to be able to take advantage of this,
	 * a user would have to gain access to the database
	 * in which case this is the least of your worries.
	 */
	echo apply_filters( 'avada_space_head', Avada()->settings->get( 'space_head' ) ); // phpcs:ignore WordPress.Security.EscapeOutput
	?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115190806-1"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-115190806-1');
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<?php
$object_id      = get_queried_object_id();
$c_page_id      = Avada()->fusion_library->get_page_id();
$wrapper_class  = 'fusion-wrapper';
$wrapper_class .= ( is_page_template( 'blank.php' ) ) ? ' wrapper_blank' : '';
?>
<body <?php body_class(); ?> <?php fusion_element_attributes( 'body' ); ?>>
	<?php do_action( 'avada_before_body_content' ); ?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'Avada' ); ?></a>

	<div id="boxed-wrapper">
		<div class="fusion-sides-frame"></div>
		<div id="wrapper" class="<?php echo esc_attr( $wrapper_class ); ?>">
			<div id="home" style="position:relative;top:-1px;"></div>
			<?php if ( has_action( 'avada_render_header' ) ) : ?>
				<?php do_action( 'avada_render_header' ); ?>
			<?php else : ?>

				<?php avada_header_template( 'below', ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && ! ( class_exists( 'WooCommerce' ) && is_shop() ) ); ?>
				<?php if ( 'left' === fusion_get_option( 'header_position' ) || 'right' === fusion_get_option( 'header_position' ) ) : ?>
					<?php avada_side_header(); ?>
				<?php endif; ?>

						<div id="sliders-container">
							<?php
							$slider_page_id = '';
							if ( ! is_search() ) {
								$slider_page_id = '';
								if ( ( ! is_home() && ! is_front_page() && ! is_archive() && isset( $object_id ) ) || ( ! is_home() && is_front_page() && isset( $object_id ) ) ) {
									$slider_page_id = $object_id;
								}
								if ( is_home() && ! is_front_page() ) {
									$slider_page_id = get_option( 'page_for_posts' );
								}
								if ( class_exists( 'WooCommerce' ) && is_shop() ) {
									$slider_page_id = get_option( 'woocommerce_shop_page_id' );
								}
								if ( ! is_home() && ! is_front_page() && ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && isset( $object_id ) && ( ! ( class_exists( 'WooCommerce' ) && is_shop() ) ) ) {
									$slider_page_id = $object_id;
									avada_slider( $slider_page_id, true );
								}
								if ( ( 'publish' === get_post_status( $slider_page_id ) && ! post_password_required() && ! is_archive() && ! Avada_Helper::bbp_is_topic_tag() ) || ( 'publish' === get_post_status( $slider_page_id ) && ! post_password_required() && ( class_exists( 'WooCommerce' ) && is_shop() ) ) || ( current_user_can( 'read_private_pages' ) && in_array( get_post_status( $slider_page_id ), array( 'private', 'draft', 'pending' ) ) ) ) {
									avada_slider( $slider_page_id, ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && ! ( class_exists( 'WooCommerce' ) && is_shop() ) );
								}
							}
							?>
						</div>
						<?php
						$slider_fallback = get_post_meta( $slider_page_id, 'pyre_fallback', true );
						?>
						<?php if ( $slider_fallback ) : ?>
							<div id="fallback-slide">
								<img src="<?php echo esc_url_raw( $slider_fallback ); ?>" alt="" />
							</div>
						<?php endif; ?>

				<!-- <?php avada_sliders_container(); ?> -->

				<?php avada_header_template( 'above', ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && ! ( class_exists( 'WooCommerce' ) && is_shop() ) ); ?>

			<?php endif; ?>

			<?php avada_current_page_title_bar( $c_page_id ); ?>

			<?php
			$row_css    = '';
			$main_class = '';

			if ( apply_filters( 'fusion_is_hundred_percent_template', false, $c_page_id ) ) {
				$row_css    = 'max-width:100%;';
				$main_class = 'width-100';
			}

			if ( fusion_get_option( 'content_bg_full' ) && 'no' !== fusion_get_option( 'content_bg_full' ) ) {
				$main_class .= ' full-bg';
			}
			do_action( 'avada_before_main_container' );
			?>
			<main id="main" class="clearfix <?php echo esc_attr( $main_class ); ?>">
				<div class="fusion-row" style="<?php echo esc_attr( $row_css ); ?>">
