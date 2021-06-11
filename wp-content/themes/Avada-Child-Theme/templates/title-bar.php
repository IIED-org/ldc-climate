<?php
/**
 * Titlebar template.
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
if(is_singular( 'press_release' ) || is_singular( 'post' ) || is_singular( 'events_activitie' ) || is_singular( 'ldc_chair_statement' )  || is_singular( 'media_briefings' )){
if(has_post_thumbnail()){
?>
<div id="sliders-container" class="ls-overflow-visible ban_prt">
<div id="layerslider-container" class="ls-overflow-visible">
<div id="layerslider-wrapper" class="ls-direction-fix ls-overflow-visible">
<div class="ls-shadow-top"></div>
<div class="ls-fullscreen-wrapper">
<img src="<?php the_post_thumbnail_url('full'); ?>" />
</div>
</div>							
<div class="ls-shadow-bottom"></div>
</div>
</div>
<?php } ?>
</div>
<?php 

$banner_caption = get_field('banner_caption');
if($banner_caption){
?>
<section class="details_sec caption_sec">
<div class="container">
<div class="details_innr">
<?php echo $banner_caption; ?>
</div>
</div>
</section>
<?php } }  ?>
<?php if(is_singular( 'page' ) || is_singular( 'country' )){
$banner_image = get_field('banner_image');
if($banner_image){
?>
<div id="sliders-container" class="ls-overflow-visible ban_prt">
<div id="layerslider-container" class="ls-overflow-visible">
<div id="layerslider-wrapper" class="ls-direction-fix ls-overflow-visible">
<div class="ls-shadow-top"></div>
<div class="ls-fullscreen-wrapper">
<img src="<?php echo $banner_image['sizes']['banner-thumb']; ?>" />
</div>
</div>							
<div class="ls-shadow-bottom"></div>
</div>
</div>
</div>
<?php 
}
$banner_caption = get_field('banner_caption');
if($banner_caption){
?>
<section class="details_sec caption_sec">
<div class="container">
<div class="details_innr">
<?php echo $banner_caption; ?>
</div>
</div>
</section>
<?php } } ?>
<div class="fusion-page-title-bar fusion-page-title-bar-<?php echo esc_attr( $content_type ); ?> fusion-page-title-bar-<?php echo esc_attr( $alignment ); ?>">
	<div class="fusion-page-title-row">
		<div class="fusion-page-title-wrapper">
        <?php if ( 'center' !== $alignment ) : // Render secondary content on left/right layout. ?>
				<?php if ( 'none' !== fusion_get_option( 'page_title_bar_bs', 'page_title_breadcrumbs_search_bar', $post_id ) ) : ?>
					<div class="fusion-page-title-secondary">
						<?php if (function_exists('qt_custom_breadcrumbs')) qt_custom_breadcrumbs(); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<div class="fusion-page-title-captions">

				<?php if ( $title ) : ?>
					<?php // Add entry-title for rich snippets. ?>
					<?php $entry_title_class = ( Avada()->settings->get( 'disable_date_rich_snippet_pages' ) && Avada()->settings->get( 'disable_rich_snippet_title' ) ) ? 'entry-title' : ''; ?>
					<?php if(is_category()){ ?>
					<h1 class="<?php echo esc_attr( $entry_title_class ); ?>"><?php printf( __( '%s', 'twentyten' ), '' . single_cat_title( '', false ) . '' );?></h1>
					<?php }elseif(is_404()){ ?>
					<?php }elseif(is_tag()){ ?>
					<h1 class="<?php echo esc_attr( $entry_title_class ); ?>"><?php printf( __( '%s', 'twentyten' ), '' . wp_trim_words(single_tag_title( '', false ),5,'...') . '' );?></h1>
					<?php }elseif(is_archive()){ ?>
					<h1 class="page-title">
					<?php if ( is_day() ) : ?>
					<?php printf( __( '%s', 'twentyten' ), get_the_date() ); ?>
					<?php elseif ( is_month() ) : ?>
					<?php printf( __( '%s', 'twentyten' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyten' ) ) ); ?>
					<?php elseif ( is_year() ) : ?>
					<?php printf( __( '%s', 'twentyten' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentyten' ) ) ); ?>
					<?php else : ?>
					<?php _e( 'Blog Archives', 'twentyten' ); ?>
					<?php endif; ?>
					</h1>
					<?php }elseif(is_search()){ ?>
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					<?php }elseif(is_singular( 'press_release' ) || is_singular( 'post' ) || is_singular( 'events_activitie' ) || is_singular( 'ldc_chair_statement' )  || is_singular( 'media_briefings' )){ ?>
					<?php }else{ ?>
					<h1 class="<?php echo esc_attr( $entry_title_class ); ?>"><?php echo get_the_title(); ?></h1>
					<?php } ?>
					<?php if ( $subtitle ) : ?>
						<h3><?php echo $subtitle; // WPCS: XSS ok. ?></h3>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( 'center' === $alignment ) : // Render secondary content on center layout. ?>
					<?php if ( 'none' !== fusion_get_option( 'page_title_bar_bs', 'page_title_breadcrumbs_search_bar', $post_id ) ) : ?>
						<div class="fusion-page-title-secondary">
							<?php if (function_exists('qt_custom_breadcrumbs')) qt_custom_breadcrumbs(); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

			</div>

			

		</div>
	</div>
</div>
