<?php
/**
 * Template for displaying Category Archive pages
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
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<div class="archive-meta">' . $category_description . '</div>';

				/*
				 * Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				?>
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
                            <section id="better-tag-cloud" class="widget widget_nktagcloud">
<?php 
if(is_active_sidebar('tag-section')):
dynamic_sidebar('tag-section');
endif;   

?>
</section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
<?php get_footer(); ?>
