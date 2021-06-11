<?php
/**
 * The theme's index.php file.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>
<?php 
$blog_id = get_option('page_for_posts');
$blog_html_new_layout = get_field('blog_html_new_layout',$blog_id); 
if($blog_html_new_layout==0):

?>
	<section id="content" <?php Avada()->layout->add_class( 'content_class' ); ?> <?php Avada()->layout->add_style( 'content_style' ); ?>>
	<?php get_template_part( 'templates/blog', 'layout' ); ?>
	</section>
	<?php do_action( 'avada_after_content' ); ?>
	
<?php elseif($blog_html_new_layout==1): ?>	
	
	<section class="news_sec">
        <div class="container123">
            <div class="news_innr">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="news_blog_inr_new">
                            <div class="row">
                            
                                <?php
                                /*
                                 * Run the loop to output the posts.
                                 * If you want to overload this in a child theme then include a file
                                 * called loop-index.php and that will be used instead.
                                 */
                                get_template_part( 'loop', 'index' );
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
<?php endif; ?>    
	
	
	
	
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
