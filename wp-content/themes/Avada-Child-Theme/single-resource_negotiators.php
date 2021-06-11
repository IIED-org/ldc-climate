<?php 
get_header();
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
$date = get_field('date');                    
$pdf_download = get_field('pdf_download'); 
?>
<section class="resources_sec_panel">
			
			 <!-- <div class="heading_country">
			 	<div class="container">
			 		<div class="row">
			 			<div class="col-sm-12">
			 				<h3>Submissions to the UNFCC</h3>
			 			</div>
			 		</div>
			 	</div>
			 </div> -->
			 
			
			 <div class="resources_panel">
			 	<div class="container">
			 		<div class="row">
			 			<div class="col-sm-12">
			 				<div class="resources_box">
                            <div class="row">
                            <div class="col-sm-6">
                            <?php 				
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 								
                            if ($image) : ?>	
                            <div class="pic_resources_box">
                            <img src="<?php echo $image[0]; ?>" alt="" />
                            </div>
                            <?php endif; ?>	
                            </div>
                            <div class="col-sm-6">
                            <div class="content_resources_box">
                            <h5>Title : <?php echo get_the_title(); ?></h5>
                            
                            <h5>Date : <span><?php echo get_the_date('d F Y'); ?></span></h5>
                            				
                            
                            <p><?php echo get_the_content(); ?></p>							<span class="time_contant tag_section"><?php echo get_the_tag_list('<p><strong>Filed under:</strong> ',', ','</p>'); ?></span>
                            <?php if($pdf_download){ ?>
                            <a href="<?php echo $pdf_download; ?>" target="_blank">Download</a>
                            <?php } ?>
                            </div>
                            </div>
                            </div>
                            </div>
			 				
			 				
			 				
			 				
			 			</div>
			 		</div>
			 	</div>
			 </div>
			
			
		</section>
<?php endwhile; ?>        
<?php get_footer(); ?>