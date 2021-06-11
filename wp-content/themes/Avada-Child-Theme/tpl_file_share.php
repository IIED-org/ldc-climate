<?php
/*Template Name: File sharing Template */

get_header(); ?>
<section class="news_sec">
        <div class="container123">
            <div class="news_innr">
                <div class="row">
                	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                    <div class="col-sm-8">
                        <div class="news_blog_inr_new">
                            <div class="rowlli">
								<?php 
								the_content(); 
								?>
							</div>
                         </div>
                    </div>
                    <?php endwhile; ?>
                    <div class="col-sm-4">
                        <div class="news_right">
                            <?php 
                            if(is_active_sidebar('file-sharing-widget')):
                                dynamic_sidebar('file-sharing-widget');
                            endif;   
                            
                            ?>
                            
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
<?php get_footer(); ?>
