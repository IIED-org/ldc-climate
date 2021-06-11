<?php
get_header();
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<section class="teamdetails_sec">
			 <div class="container">
			 	<div class="teamdetails_secin">
			 		<!-- <h3><?php the_title(); ?></h3> -->
			 		<div class="teamdetails_row">
			 			<?php 				
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 								
						if ($image) : ?>
			 			<div class="teamdetails_pic"><img src="<?php echo $image[0]; ?>" alt="" />
			 				<!-- <span>Photo: UNDP India</span> -->
			 			</div>
			 			<?php endif; ?>
						<?php the_content(); ?>
			 		</div>	
			 	</div>
			</div>
		</section>
<section class="country_srchlistall grp_sngl">
	<div class="container">
		<div class="country_srchlistall_in">
			<h3>Related Resources</h3>
			<div class="country_srchlistall_col">
 <?php 
        /*
         *  Query posts for a relationship value.
         *  This method uses the meta_query LIKE to match the string "123" to the database value a:1:{i:0;s:3:"123";} (serialized array)
         */

         $documents = get_posts(array(
                     'post_type' => array('resource','submissions_unfccc','ndcs','post','communications','press_release','events_activitie','ldc_chair_statement','media_briefings','resource_negotiators','knowledge_repository'),
					 'posts_per_page'    => -1,
					 'oderby' => 'date',
					 'order' => 'DESC',
                     'meta_query' => array(
                      array(
                            'key' => 'team_relation', // name of custom field
                            'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                                )
                            )
                        ));
						?>
        <?php if( $documents ): ?>
        	<div class="country_srchlistall_box">
             <ul>
             <?php foreach( $documents as $document ): 
             	   $documents = get_post_type_object(get_post_type($document->ID));	
				   $documents_content = get_the_content( $document->ID );
				   $image = wp_get_attachment_image_src( get_post_thumbnail_id( $document->ID ), 'full' );
				   ?>
                <li>
                   
                   <div class="con_img"><a href="<?php echo get_permalink( $document->ID ); ?>"><img src="<?php echo $image[0]; ?>" width="70" height="70" /></a></div>
                   <div class="con_des">
                   <strong><a href="<?php echo get_permalink( $document->ID ); ?>">
                     <span><?php echo get_the_title( $document->ID ); ?></span>
                   </a></strong> - <strong><?php echo esc_html($documents->labels->singular_name); ?></strong>
                   <p><strong><?php echo get_the_date('d F Y',$document->ID); ?></strong></p>
                   
                    <?php 
                    $page_data = get_post( $document->ID ); 
					$content = apply_filters('the_content', $page_data->post_content); 
					//$title = $page_data->post_title; 
					//echo $content;
                    ?>
                    <p><?php echo wp_trim_words($content,30,'...')?><a href="<?php the_permalink($document->ID); ?>">Read More</a></p>
                    <!-- <p><?php echo strlen(substr(strip_tags($content),0,150)) ?substr(strip_tags($content),0,150).'&nbsp;' : $content.'&nbsp;';?><a href="<?php the_permalink($document->ID); ?>">Read More</a></p> -->
                    </div>
                </li>
             <?php endforeach; ?>
            </ul>
           </div>
      <?php endif; ?>			

			</div>
		</div>
	</div>
</section>
<?php endwhile; ?>		
<?php get_footer(); ?>