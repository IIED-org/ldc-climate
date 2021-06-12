<?php
function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );
require 'acf.php';

add_image_size('thumbnail-new',230,221, TRUE);

register_sidebar( array(
        'name' => __( 'Footer Last Widget Area', 'twentyten' ),
        'id' => 'footer-last-widget-area',
        'description' => __( 'Add widgets here to appear in your sidebar.', 'twentyten' ),
        'before_widget' => '<div id="%1$s" class="row widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="foot_bottom_lt"><h3>',
        'after_title' => '</h3></div>',
    ) );

register_sidebar( array(
        'name' => __( 'Tag Section', 'twentyten' ),
        'id' => 'tag-section',
        'description' => __( 'Add widgets here to appear in your sidebar.', 'twentyten' ),
        'before_widget' => '<div id="%1$s" class="row widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="heading"><h4 class="widget-title">',
        'after_title' => '</h4></div>',
    ) );

register_sidebar( array(
        'name' => __( 'File sharing widget', 'twentyten' ),
        'id' => 'file-sharing-widget',
        'description' => __( 'Add widgets here to appear in your sidebar.', 'twentyten' ),
        'before_widget' => '<div id="%1$s" class="row widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="heading"><h4 class="widget-title">',
        'after_title' => '</h4></div>',
    ) );
register_sidebar( array(
        'name' => __( 'Search Section', 'twentyten' ),
        'id' => 'search_sec',
        'description' => __( 'Add widgets here to appear in your sidebar.', 'twentyten' ),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ) );

add_shortcode( 'country-list', 'ns_country_list_parameters_shortcode' );
function ns_country_list_parameters_shortcode( $atts ) {
ob_start();
extract( shortcode_atts( array (
'type' => 'country',
'order' => 'ASC',
'orderby' => 'title',
'posts' => -1,
'category' => '',
), $atts ) );
$options = array(
'post_type' => $type,
'order' => $order,
'orderby' => $orderby,
'posts_per_page' => $posts,
'category_name' => $category,
);
$query = new WP_Query( $options );
if ( $query->have_posts() ) {
?>
<div class="content_country">
			 	<div class="container">
			 		<div class="row">
 				<div id="post-<?php the_ID(); ?>" <?php post_class('ourserv_boxrow'); ?>>
				<?php while ( $query->have_posts() ) : $query->the_post();
				?>
				<div class="col-md-3 col-sm-4 col-xs-6">
			 				<div class="countries_box">
			 					<div class="media">
			 					<?php
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
								if ($image) : ?>
							    <div class="media-left">
							    <a href="<?php the_permalink(); ?>"><img src="<?php echo $image[0]; ?>" class="media-object"/></a>
							    </div>
							    <?php endif; ?>
							    <div class="media-body">
							      <h4 class="media-heading"><?php echo get_the_title(); ?></h4>
							    </div>
			 					</div>
			 					<a href="<?php the_permalink(); ?>" class="country_abs"></a>
			 				</div>
			 			</div>

			    <?php endwhile; ?>
			</div>
 			</div>
 		</div>
 	</div>
<?php
$myvariable = ob_get_clean();
return $myvariable;
}
}

function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Blog';
    $submenu['edit.php'][5][0] = 'Blog';
    $submenu['edit.php'][10][0] = 'Add Blog';
    $submenu['edit.php'][16][0] = 'Blog Tags';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Blog';
    $labels->singular_name = 'Blog';
    $labels->add_new = 'Add Blog';
    $labels->add_new_item = 'Add Blog';
    $labels->edit_item = 'Edit Blog';
    $labels->new_item = 'Blog';
    $labels->view_item = 'View Blog';
    $labels->search_items = 'Search Blog';
    $labels->not_found = 'No Blog found';
    $labels->not_found_in_trash = 'No Blog found in Trash';
    $labels->all_items = 'All Blog';
    $labels->menu_name = 'Blog';
    $labels->name_admin_bar = 'Blog';
}

add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );

/******** Team Section *************/
add_image_size( 'team-thumb', 250, 300,TRUE);
add_image_size( 'banner-thumb', 1300, 450,TRUE);
function w4dev_team_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'team',
		'posts_per_page' 	=> '6',
		'post_status' 		=> 'publish'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );?>

	<?php if( $custom_query->have_posts() ):?>
	<section class="about_heading_sec">
	<div class="container">
		<div class="row">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
		$title = get_field('title');
		$chair_dates = get_field('chair_dates');
		$brief_blog = get_field('brief_blog');
		?>
		<div class="col-sm-4 col-xs-6">
					<div class="abt_boxx">

						<div class="abt_boxx_pic"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('team-thumb'); ?></a></div>

						<div class="abt_boxx_txt">
						<div class="abt_boxx_txt_heading">
						<h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
						<?php if($title){ ?>
						<h4><?php echo $title; ?></h4>
						<?php } ?>
						<?php if($chair_dates){ ?>
						<h4><?php echo $chair_dates; ?></h4>
						<?php } ?>
						<?php if($brief_blog){ ?>
						<h4><?php echo $brief_blog; ?></h4>
						<?php } ?>
						</div>
						<div class="abt_boxx_txt_con">
						<p><?php echo wp_trim_words(get_the_content(),25,''); ?> &nbsp;<a href="<?php the_permalink(); ?>">Read More</a></p>
						</div>
						</div>

				   </div>
				</div>

		<?php
		endwhile;
		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));

	echo '<div class="pagination_sec pagination clearfix">'.$html.'</div>';
		?>

	</div>
	</div>
</section>
	<?php endif;
$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_loop_team', 'w4dev_team_custom_loop_shortcode' );
/*--------------------   ----------------------------*/
function w4dev_ldc_coordinator_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'ldc_coordinator',
		'posts_per_page' 	=> '6',
		'post_status' 		=> 'publish'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );?>

	<?php if( $custom_query->have_posts() ):?>
	<section class="about_heading_sec">
	<div class="container">
		<div class="row">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
		$title = get_field('title');
		$chair_dates = get_field('chair_dates');
		$brief_blog = get_field('brief_blog');
		?>
		<div class="col-sm-4 col-xs-6">
					<div class="abt_boxx">

						<div class="abt_boxx_pic"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('team-thumb'); ?></a></div>

						<div class="abt_boxx_txt">
						<div class="abt_boxx_txt_heading">
						<h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
						<?php if($title){ ?>
						<h4><?php echo $title; ?></h4>
						<?php } ?>
						<?php if($chair_dates){ ?>
						<h4><?php echo $chair_dates; ?></h4>
						<?php } ?>
						<?php if($brief_blog){ ?>
						<h4><?php echo $brief_blog; ?></h4>
						<?php } ?>
						</div>
						<div class="abt_boxx_txt_con">
						<p><?php echo wp_trim_words(get_the_content(),25,''); ?> &nbsp;<a href="<?php the_permalink(); ?>">Read More</a></p>
						</div>
						</div>

				   </div>
				</div>

		<?php
		endwhile;
		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));

	echo '<div class="pagination_sec pagination clearfix">'.$html.'</div>';
		?>

	</div>
	</div>
</section>
	<?php endif;
$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_loop_ldc_coordinator', 'w4dev_ldc_coordinator_custom_loop_shortcode' );

/***************** LDC Paper Series **************/
function w4dev_group_chair_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'group_chair',
		'posts_per_page' 	=> '6',
		'post_status' 		=> 'publish'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );?>

	<?php if( $custom_query->have_posts() ):?>
	<section class="about_heading_sec">
	<div class="container">
		<div class="row">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
		$title = get_field('title');
		$chair_dates = get_field('chair_dates');
		$brief_blog = get_field('brief_blog');
		?>
		<div class="col-sm-4 col-xs-6">
					<div class="abt_boxx">

						<div class="abt_boxx_pic"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('team-thumb'); ?></a></div>

						<div class="abt_boxx_txt">
						<div class="abt_boxx_txt_heading">
						<h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
						<?php if($title){ ?>
						<h4><?php echo $title; ?></h4>
						<?php } ?>
						<?php if($chair_dates){ ?>
						<h4><?php echo $chair_dates; ?></h4>
						<?php } ?>
						<?php if($brief_blog){ ?>
						<h4><?php echo $brief_blog; ?></h4>
						<?php } ?>
						</div>
						<div class="abt_boxx_txt_con">
						<p><?php echo wp_trim_words(get_the_content(),25,''); ?>&nbsp;<a href="<?php the_permalink(); ?>">Read More</a></p>
						</div>
						</div>

				   </div>
				</div>

		<?php
		endwhile;
		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));

	echo '<div class="pagination_sec pagination clearfix">'.$html.'</div>';
		?>

	</div>
	</div>
</section>
	<?php endif;
$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_loop_group_chair', 'w4dev_group_chair_custom_loop_shortcode' );
/***************** LDC Paper Series **************/

function w4dev_resource_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'resource',
		'posts_per_page' 	=> '5',
		'post_status' 		=> 'publish',
		'order'             => 'DESC'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>
<div class="resources_panel">
 	<div class="container">
 		<div class="row">
 			<div class="col-sm-12">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  $date = get_field('date');
			  $themes = get_field('themes');
			  $information_and_download = get_field('information_and_download');
		?>
			   <div class="resources_box">
				<div class="row">
				<div class="col-sm-6">
				<?php
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				if ($image) : ?>
				<div class="pic_resources_box">
				<a><img src="<?php echo $image[0]; ?>" alt="" /></a>
				</div>
				<?php endif; ?>
				</div>
				<div class="col-sm-6">
				<div class="content_resources_box">
				<h5><?php echo get_the_title(); ?></h5>
				<?php //if($date){ ?>
				<h5>Date : <span><?php echo get_the_date('d F Y'); ?></span></h5>
				<?php //} ?>
				<!-- <?php if($themes){ ?>
				<h5>Themes : <span><?php echo $themes; ?></span></h5>
				<?php } ?> -->
				<p><?php echo get_the_content(); ?></p>
				<?php if($information_and_download){ ?>
				<a href="<?php echo $information_and_download; ?>" target="_blank">Download</a>
				<?php } ?>
				</div>
				</div>
				</div>
				</div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>
	      </div>
	   </div>
   </div>
</div>
	<?php endif;


$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_resource_loop', 'w4dev_resource_custom_loop_shortcode' );

/*********** National communications  *******************/
function w4dev_communications_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'communications',
		'posts_per_page' 	=> '5',
		'post_status' 		=> 'publish',
		'order'             => 'DESC'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>
<div class="resources_panel">
 	<div class="container">
 		<div class="row">
 			<div class="col-sm-12">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  $date = get_field('date');
			  $themes = get_field('themes');
			  $information_and_download = get_field('information_and_download');
		?>
			   <div class="resources_box">
				<div class="row">
				<div class="col-sm-6">
				<?php
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				if ($image) : ?>
				<div class="pic_resources_box">
				<a><img src="<?php echo $image[0]; ?>" alt="" /></a>
				</div>
				<?php endif; ?>
				</div>
				<div class="col-sm-6">
				<div class="content_resources_box">
				<h5><?php echo get_the_title(); ?></h5>
				<?php //if($date){ ?>
				<h5>Date : <span><?php echo get_the_date('d F Y'); ?></span></h5>
				<?php //} ?>
				<!-- <?php if($themes){ ?>
				<h5>Themes : <span><?php echo $themes; ?></span></h5>
				<?php } ?> -->
				<p><?php echo get_the_content(); ?></p>
				<?php if($information_and_download){ ?>
				<a href="<?php echo $information_and_download; ?>">Download</a>
				<?php } ?>
				</div>
				</div>
				</div>
				</div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>
	      </div>
	   </div>
   </div>
</div>
	<?php endif;


$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_communications_loop', 'w4dev_communications_custom_loop_shortcode' );


/***************** NDCs/INDCs  ******************/

function w4dev_ndcs_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'ndcs',
		'posts_per_page' 	=> '5',
		'post_status' 		=> 'publish',
		'order'             => 'DESC'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>
<div class="resources_panel">
 	<div class="container">
 		<div class="row">
 			<div class="col-sm-12">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  $date = get_field('date');
			  $themes = get_field('themes');
			  $information_and_download = get_field('information_and_download');
		?>
			   <div class="resources_box">
				<div class="row">
				<div class="col-sm-6">
				<?php
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				if ($image) : ?>
				<div class="pic_resources_box">
				<a><img src="<?php echo $image[0]; ?>" alt="" /></a>
				</div>
				<?php endif; ?>
				</div>
				<div class="col-sm-6">
				<div class="content_resources_box">
				<h5><?php echo get_the_title(); ?></h5>
				<h5>Date : <span><?php echo get_the_date('d F Y'); ?></span></h5>

				<p><?php echo get_the_content(); ?></p>
				<?php if($information_and_download){ ?>
				<a href="<?php echo $information_and_download; ?>">Download</a>
				<?php } ?>
				</div>
				</div>
				</div>
				</div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>
	      </div>
	   </div>
   </div>
</div>
	<?php endif;


$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_ndcs_loop', 'w4dev_ndcs_custom_loop_shortcode' );

/***************** Submissions to the UNFCC **************/

function w4dev_unfcc_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'submissions_unfccc',
		'posts_per_page' 	=> '5',
		'post_status' 		=> 'publish',
		'order'             => 'DESC'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>
<div class="resources_panel">
 	<div class="container">
 		<div class="row">
 			<div class="col-sm-12">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  $date = get_field('date');
				$pdf_download = get_field('pdf_download');
		?>
			   <div class="resources_box">
				<div class="row">
				<div class="col-sm-6">
				<?php
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				if ($image) : ?>
				<div class="pic_resources_box">
				<a><img src="<?php echo $image[0]; ?>" alt="" /></a>
				</div>
				<?php endif; ?>
				</div>
				<div class="col-sm-6">
				<div class="content_resources_box">
				<h5><?php echo get_the_title(); ?></h5>

				<h5>Date : <span><?php echo get_the_date('d F Y'); ?></span></h5>


				<p><?php echo get_the_content(); ?></p>
				<?php if($pdf_download){ ?>
				<a href="<?php echo $pdf_download; ?>" target="_blank">Download</a>
				<?php } ?>
				</div>
				</div>
				</div>
				</div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>
	      </div>
	   </div>
   </div>
</div>
	<?php endif;


	$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_unfcc_loop', 'w4dev_unfcc_custom_loop_shortcode' );


/***************** Statement from the LDC Chair **************/

function w4dev_ldcchair_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'ldc_chair',
		'posts_per_page' 	=> '5',
		'post_status' 		=> 'publish'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>
<div class="resources_panel">
 	<div class="container">
 		<div class="row">
 			<div class="col-sm-12">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  $date = get_field('date');
		?>
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
				<h5>Title : <span><?php echo get_the_title(); ?></span></h5>

				<h5>Date : <span><?php echo get_the_date('d F Y'); ?></span></h5>


				<?php echo get_the_content(); ?>

				</div>
				</div>
				</div>
				</div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>
	      </div>
	   </div>
   </div>
</div>
	<?php endif;


	$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_ldcchair_loop', 'w4dev_ldcchair_custom_loop_shortcode' );

/***************** Press Releases **************/

function w4dev_press_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'press_release',
		'posts_per_page' 	=> '15',
		'post_status' 		=> 'publish',
		'orderby'           => 'date',
		'order'             => 'desc'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>

		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  //$date = get_field('date');
		?>
			  <div class="col-sm-4 col-xs-6">
                <div class="news_box">
                    <?php if(has_post_thumbnail()){ ?>
                    <div class="news_pic_box">
                        <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php echo strip_tags(get_the_title()); ?>" /></a>
                    </div>
                    <?php } ?>
                    <div class="news_text_box">
                        <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                        <?php
						//$date = get_field('date');
						//if($date){
						?>
                        <h4><?php echo get_the_date('d F Y'); ?></h4>
                        <?php // } ?>

                        <p><?php echo wp_trim_words(get_the_content(),12,''); ?> <a href="<?php the_permalink(); ?>">Read More</a></p>
                        <!-- <p><strong><a href="<?php the_permalink(); ?>">Read More</a></strong></p> -->
                    </div>
                </div>
            </div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>

	<?php endif;


	$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_press_loop', 'w4dev_press_custom_loop_shortcode' );



/***************** Events and Activities **************/

function w4dev_event_activities_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'events_activitie',
		'posts_per_page' 	=> '15',
		'post_status' 		=> 'publish',
		'orderby'           => 'date',
		'order'             => 'desc'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>

		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  //$date = get_field('date');
		?>
			  <div class="col-sm-4 col-xs-6">
                <div class="news_box">
                    <?php if(has_post_thumbnail()){ ?>
                    <div class="news_pic_box">
                        <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php echo strip_tags(get_the_title()); ?>" /></a>
                    </div>
                    <?php } ?>
                    <div class="news_text_box">
                        <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                        <?php
						//$date = get_field('date');
						//if($date){
						?>
                        <h4><?php echo get_the_date('d F Y'); ?></h4>
                        <?php // } ?>

                        <p><?php echo wp_trim_words(get_the_content(),12,''); ?> <a href="<?php the_permalink(); ?>">Read More</a></p>
                        <!-- <p><strong><a href="<?php the_permalink(); ?>">Read More</a></strong></p> -->
                    </div>
                </div>
            </div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>

	<?php endif;


	$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_event_activities_loop', 'w4dev_event_activities_custom_loop_shortcode' );


/***************** LDC Chair Statements **************/

function w4dev_ldc_chair_statement_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'ldc_chair_statement',
		'posts_per_page' 	=> '15',
		'post_status' 		=> 'publish',
		'orderby'           => 'date',
		'order'             => 'desc'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>

		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  //$date = get_field('date');
		?>
			  <div class="col-sm-4 col-xs-6">
                <div class="news_box">
                    <?php if(has_post_thumbnail()){ ?>
                    <div class="news_pic_box">
                        <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php echo strip_tags(get_the_title()); ?>" /></a>
                    </div>
                    <?php } ?>
                    <div class="news_text_box">
                        <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                        <?php
						//$date = get_field('date');
						//if($date){
						?>
                        <h4><?php echo get_the_date('d F Y'); ?></h4>
                        <?php // } ?>

                        <p><?php echo wp_trim_words(get_the_content(),12,''); ?> <a href="<?php the_permalink(); ?>">Read More</a></p>
                        <!-- <p><strong><a href="<?php the_permalink(); ?>">Read More</a></strong></p> -->
                    </div>
                </div>
            </div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>

	<?php endif;


	$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_ldc_chair_statement_loop', 'w4dev_ldc_chair_statement_custom_loop_shortcode' );


/***************** Media Briefing **************/

function w4dev_media_briefings_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'media_briefings',
		'posts_per_page' 	=> '15',
		'post_status' 		=> 'publish',
		'orderby'           => 'date',
		'order'             => 'desc'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>

		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  //$date = get_field('date');
		?>
			  <div class="col-sm-4 col-xs-6">
                <div class="news_box">
                    <?php if(has_post_thumbnail()){ ?>
                    <div class="news_pic_box">
                        <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php echo strip_tags(get_the_title()); ?>" /></a>
                    </div>
                    <?php } ?>
                    <div class="news_text_box">
                        <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                        <?php
						//$date = get_field('date');
						//if($date){
						?>
                        <h4><?php echo get_the_date('d F Y'); ?></h4>
                        <?php // } ?>

                        <p><?php echo wp_trim_words(get_the_content(),12,''); ?> <a href="<?php the_permalink(); ?>">Read More</a></p>
                        <!-- <p><strong><a href="<?php the_permalink(); ?>">Read More</a></strong></p> -->
                    </div>
                </div>
            </div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>

	<?php endif;


	$myvariable = ob_get_clean();
return $myvariable;

}

add_shortcode( 'w4dev_custom_media_briefings_loop', 'w4dev_media_briefings_custom_loop_shortcode' );


function qt_custom_breadcrumbs() {

  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = '&raquo;'; // delimiter between crumbs
  $home = 'Home'; // text for the 'Home' link
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb

  global $post;
  $homeLink = get_bloginfo('url');

  if (is_home() || is_front_page()) {

    if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';

  } else {

    echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

    if ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
	  if(is_category(1)){
	  echo $before . '<a href="' . get_permalink(13505) . '">News</a> &raquo; ' . single_cat_title('', false) . '' . $after;
	  }else{
      echo $before . '' . single_cat_title('', false) . '' . $after;

	  }

     }elseif ( is_tag() ) {
     	echo $before . '' . single_tag_title( '', false ) . '' . $after;
	 }
     elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;

    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
		if(is_singular('country')){
		  echo '<a href="' . get_permalink(11926) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('group_chair')){
		  echo '<a href="' . get_permalink(13117) . '">About Us</a> &raquo; <a href="' . get_permalink(12278) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('team')){
		  echo '<a href="' . get_permalink(13117) . '">About Us</a> &raquo; <a href="' . get_permalink(11879) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('ldc_coordinator')){
		  echo '<a href="' . get_permalink(13117) . '">About Us</a> &raquo; <a href="' . get_permalink(14489) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('resource')){
		  echo '<a href="' . get_permalink(13133) . '">Resources</a> &raquo; <a href="' . get_permalink(11908) . '">' . $post_type->labels->singular_name . '</a>';

		}elseif(is_singular('submissions_unfccc')){
		  echo '<a href="' . get_permalink(13133) . '">Resources</a> &raquo; <a href="' . get_permalink(11986) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('press_release')){
		  echo '<a href="' . get_permalink(13505) . '">News</a> &raquo; <a href="' . get_permalink(13375) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('events_activitie')){
		  echo '<a href="' . get_permalink(13505) . '">News</a> &raquo; <a href="' . get_permalink(13380) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('ldc_chair_statement')){
		  echo '<a href="' . get_permalink(13505) . '">News</a> &raquo; <a href="' . get_permalink(13382) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('media_briefings')){
		  echo '<a href="' . get_permalink(13505) . '">News</a> &raquo; <a href="' . get_permalink(13384) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('resource_negotiators')){
		  echo '<a href="' . get_permalink(13133) . '">Resources</a> &raquo; <a href="' . get_permalink(14227) . '">' . $post_type->labels->singular_name . '</a>';
		}elseif(is_singular('knowledge_repository')){
		  echo '<a href="' . get_permalink(13133) . '">Resources</a> &raquo; <a href="' . get_permalink(14230) . '">' . $post_type->labels->singular_name . '</a>';
		}

        //$slug = $post_type->rewrite;
        //echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
        if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title(). $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
		if(is_singular('post')){
		echo '<a href="' . get_permalink(13505) . '">News</a> &raquo; '.$cats;
		}else{
        echo $cats;
	    }
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
      }
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title( '', false ) . '"' . $after;

    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;

    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</div>';

  }
}

function mySearchFilter($query) {
    $post_type = $_GET['post_type'];

    if ($query->is_search) {
        if (!empty($post_type)) {
           $query->set('post_type', $post_type);
    }
  }
    return $query;
}

add_filter('pre_get_posts','mySearchFilter');




function w4dev_resource_negotiators_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'resource_negotiators',
		'posts_per_page' 	=> '5',
		'post_status' 		=> 'publish',
		'order'             => 'DESC'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>
<div class="resources_panel">
 	<div class="container">
 		<div class="row">
 			<div class="col-sm-12">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  $date = get_field('date');
			  $themes = get_field('themes');
			  $information_and_download = get_field('information_and_download');
		?>
			   <div class="resources_box">
				<div class="row">
				<div class="col-sm-6">
				<?php
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				if ($image) : ?>
				<div class="pic_resources_box">
				<a><img src="<?php echo $image[0]; ?>" alt="" /></a>
				</div>
				<?php endif; ?>
				</div>
				<div class="col-sm-6">
				<div class="content_resources_box">
				<h5><?php echo get_the_title(); ?></h5>
				<?php //if($date){ ?>
				<h5>Date : <span><?php echo get_the_date('d F Y'); ?></span></h5>
				<?php //} ?>
				<!-- <?php if($themes){ ?>
				<h5>Themes : <span><?php echo $themes; ?></span></h5>
				<?php } ?> -->
				<p><?php echo get_the_content(); ?></p>
				<?php if($information_and_download){ ?>
				<a href="<?php echo $information_and_download; ?>" target="_blank">Download</a>
				<?php } ?>
				</div>
				</div>
				</div>
				</div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>
	      </div>
	   </div>
   </div>
</div>
	<?php endif;


$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_resource_negotiators_loop', 'w4dev_resource_negotiators_custom_loop_shortcode' );


function w4dev_knowledge_repository_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'knowledge_repository',
		'posts_per_page' 	=> '5',
		'post_status' 		=> 'publish',
		'order'             => 'DESC'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	//$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );

	if( $custom_query->have_posts() ):?>
<div class="resources_panel">
 	<div class="container">
 		<div class="row">
 			<div class="col-sm-12">
		<?php while( $custom_query->have_posts()) : $custom_query->the_post();
			  $date = get_field('date');
			  $themes = get_field('themes');
			  $information_and_download = get_field('information_and_download');
		?>
			   <div class="resources_box">
				<div class="row">
				<div class="col-sm-6">
				<?php
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				if ($image) : ?>
				<div class="pic_resources_box">
				<a><img src="<?php echo $image[0]; ?>" alt="" /></a>
				</div>
				<?php endif; ?>
				</div>
				<div class="col-sm-6">
				<div class="content_resources_box">
				<h5><?php echo get_the_title(); ?></h5>
				<?php //if($date){ ?>
				<h5>Date : <span><?php echo get_the_date('d F Y'); ?></span></h5>
				<?php //} ?>
				<!-- <?php if($themes){ ?>
				<h5>Themes : <span><?php echo $themes; ?></span></h5>
				<?php } ?> -->
				<p><?php echo get_the_content(); ?></p>
				<?php if($information_and_download){ ?>
				<a href="<?php echo $information_and_download; ?>" target="_blank">Download</a>
				<?php } ?>
				</div>
				</div>
				</div>
				</div>

		<?php
		endwhile;?>
		<?php

		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));
   	echo  '<div class="pagination_sec pagination clearfix">'.$html.'</div>';

	//$myvariable.=$html;
	?>
	      </div>
	   </div>
   </div>
</div>
	<?php endif;


$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_knowledge_repository_loop', 'w4dev_knowledge_repository_custom_loop_shortcode' );


function wp_new_search_form(){
	 get_search_form();
}
add_shortcode('new-search-form','wp_new_search_form');


function misha_my_load_more_scripts() {

	global $wp_query;

	// In most cases it is already included on the page and this line can be removed
	wp_enqueue_script('jquery');

	// register our main script but do not enqueue it yet
	wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/js/myloadmore.js', array('jquery') );

	// now the most interesting part
	// we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
	wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );

 	wp_enqueue_script( 'my_loadmore' );
}

add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );


function misha_loadmore_ajax_handler(){

	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';

	// it is always better to use WP_Query but not here
	query_posts( $args );

	if( have_posts() ) :

		// run the loop
		while( have_posts() ): the_post();

			// look into your theme code how the posts are inserted, but you can use your own HTML of course
			// do you remember? - my example is adapted for Twenty Seventeen theme
			get_template_part( 'template-parts/post/content', get_post_format() );
			// for the test purposes comment the line above and uncomment the below one
			// the_title();


		endwhile;

	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}

/***************** Thimphu Ambtion Statememts  **************/
add_image_size( 'flag', 250, 167,TRUE);
function w4dev_ambition_statement_custom_loop_shortcode( $atts )
{
	ob_start();
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'ambition_statement',
		'posts_per_page' 	=> '12',
		'post_status' 		=> 'publish',
    'order' => 'ASC'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	$html  = '';
	$custom_query = new WP_Query( $atts );


	$pagination_base = add_query_arg( $paging, '%#%' );?>

	<?php if( $custom_query->have_posts() ):?>
	<section class="about_heading_sec">
	<div class="container">

		<?php
    $counter = 0;
    while( $custom_query->have_posts()) : $custom_query->the_post();
    if ($counter % 3 == 0) :
      echo $counter > 0 ? "</div>" : "";
      echo "<div class='row'>";
    endif;
    ?>
		<div class="col-sm-4 col-xs-6">
					<div class="abt_boxx">

						<div class="abt_boxx_pic"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('flag'); ?></a></div>

						<div class="abt_boxx_txt">
						<div class="abt_boxx_txt_heading">
						<h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>

						</div>
						<div class="abt_boxx_txt_con">
						<p><a href="<?php the_permalink(); ?>">Read More</a></p>
						</div>
						</div>

				   </div>
				</div>
		<?php
    $counter++;
		endwhile;
		$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));

	echo '<div class="pagination_sec pagination clearfix">'.$html.'</div>';
		?>

	</div>
	</div>
</section>
	<?php endif;
$myvariable = ob_get_clean();
return $myvariable;

}
add_shortcode( 'w4dev_custom_loop_ambition_statement', 'w4dev_ambition_statement_custom_loop_shortcode' );


add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}


function wpse28145_add_custom_types( $query ) {
    if( is_tag() && $query->is_main_query() ) {

        // this gets all post types:
        $post_types = get_post_types();

        // alternately, you can add just specific post types using this line instead of the above:
        // $post_types = array( 'post', 'your_custom_type' );

        $query->set( 'post_type', $post_types );
    }
}
add_filter( 'pre_get_posts', 'wpse28145_add_custom_types' );

add_action('after_setup_theme', 'remove_core_updates');

function remove_core_updates() {

if (!current_user_can('update_core')) {
  return;
}

add_action('init', create_function('$a', "remove_action( 'init', 'wp_version_check' );"), 2);
add_filter('pre_option_update_core', '__return_null');
add_filter('pre_site_transient_update_core', '__return_null');

}
