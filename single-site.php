<?php get_header(); 

	$url = get_post_meta($post->ID, 'URL', true);
	$year = get_post_meta($post->ID, 'year', true);
	// $client = get_post_meta($post->ID, 'URL', true);
	$images = array();

	$site_images = get_posts( array(
		'post_type' => 'attachment',
		'orderby' => 'menu_order',
		'order' => 'asc',
		'posts_per_page' => -1,
		'post_parent' => $post->ID,
	) );

	if ( $site_images ) :
		foreach ( $site_images as $img ) :
			$image = wp_get_attachment_image_src( $img->ID, 'medium' );
			$images[] = '<img src="'.$image[0].'" id="'.$img->post_name.'" alt="" />';
		endforeach; 
	endif;

	$prev_site = get_adjacent_post(false, '', false);
	$next_site = get_adjacent_post(false, '', true);

?>

	<div id="main">
		<section>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div class="info">
				<?php echo ($prev_site) ? '<a class="prev" href="'.get_permalink($prev_site->ID).'"></a>' : '<a class="prev disabled" href"#"></a>'; ?>
				<h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
				<?php echo $url; // [TODO] debug ?>
				<?php echo ($next_site) ? '<a class="next" href="'.get_permalink($next_site->ID).'"></a>' : '<a class="next disabled" href"#"></a>'; ?>
			</div>
			<div class="screens">
				<?php echo implode('', $images); ?>
			</div>

		<?php endwhile; else: ?>

			<h2>Whoops, you probably got here by accident. Go back.</h2>

		<?php endif; ?>

		</section>
	</div>

<?php get_footer(); ?>