<?php
get_header();
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<section class="teamdetails_sec">
			 <div class="container">
			 	<div class="teamdetails_secin">
			 		<!-- <h3><?php the_title(); ?></h3> -->
			 		<div class="teamdetails_row">
							<?php the_content(); ?>
							<!-- <?php
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
							if ($image) : ?>
							<div class="flag"><img width="300" src="<?php echo $image[0]; ?>" alt="Country flag" />
							</div>
								<?php endif; ?> -->
					</div>
			 	</div>
			</div>
		</section>
<?php endwhile; ?>
<?php get_footer(); ?>
