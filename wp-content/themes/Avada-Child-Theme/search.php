<?php
/**
 * Template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<section class="news_sec">
        <div class="container123">
            <div class="news_innr">
                <div class="row">
		
				<div class="col-sm-8">
				<div class="news_blog_inr_new">
				<div class="row">

<?php if ( have_posts() ) : ?>
				<!-- <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></h1> -->
				<?php
				/*
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'No Results', 'twentyten' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
						
						<?php echo do_shortcode( '[wi_autosearch_suggest_form]' ); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
<?php endif; ?>
			</div>
				</div>
				</div>
				<div class="col-sm-4">
				<div class="news_right">
				<?php 
				if(is_active_sidebar('avada-blog-sidebar')):
				dynamic_sidebar('avada-blog-sidebar');
				endif;   
				
				?>
				<!-- <section id="better-tag-cloud" class="widget widget_nktagcloud">
<?php 
if(is_active_sidebar('tag-section')):
dynamic_sidebar('tag-section');
endif;   

?>
</section> -->
				</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
