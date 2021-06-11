<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'twentyten' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>


<?php while ( have_posts() ) : the_post(); ?>

<?php /* How to display posts of the Gallery format. The gallery category is the old way. */ ?>

	
		
		    
		    <div class="col-sm-4 col-xs-6 post">
                <div class="news_box">
                    <?php if(has_post_thumbnail()){ ?>
                    <div class="news_pic_box">
                        <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php echo strip_tags(get_the_title()); ?>" style="height:100px;"/></a>
                    </div>
                    <?php } ?>
                    <div class="news_text_box">
                        <h3><a title="<?php echo strip_tags(get_the_title()); ?>" href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                        <?php 
						//$date = get_field('date');
						//if($date){
						?>
                        <h4><?php echo get_the_date('d F Y'); ?></h4>
                        <?php // } ?>
                       
                        <p><?php echo wp_trim_words(get_the_content(),12,''); ?> <strong><a href="<?php the_permalink(); ?>">Read More</a></strong></p>
                        <!-- <p><strong><a href="<?php the_permalink(); ?>">Read More</a></strong></p> -->
                    </div>
                </div>
            </div>
		    
		  
		

		

	

<?php endwhile; // End the loop. Whew. ?>


	<?php //echo paginate_links( $args ); 
                                                
    $big = 999999999; // need an unlikely integer

    $pages = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'prev_text'          => __( '<i class="fa fa-angle-left" aria-hidden="true"></i> Prev', 'avada-child-theme' ),
            'next_text'          => __( 'Next <i class="fa fa-angle-right" aria-hidden="true"></i>', 'avada-child-theme' ),
            'type'  => 'array',
        ) );
        if( is_array( $pages ) ) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
            echo '<div class="pagination clearfix">';
            foreach ( $pages as $page ) {
                    echo "$page";
            }
           echo '</div>';
            }
    
    wp_reset_query();
    ?>


<?php //echo fusion_pagination( '', 2 ); // WPCS: XSS ok. ?>