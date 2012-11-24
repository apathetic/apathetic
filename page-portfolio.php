<?php get_header(); ?>

	<div id="filter" class="clearfix">
		<ul>
			<li><a href="#" data-filter="*">show all</a></li>
			<?php foreach((get_tags()) as $tag) {
				echo '<li><a href="#" data-filter=".'.strtolower($tag->name).'">'.$tag->name.'</a></li>';
			} ?>
		</ul>
	</div>

	<div id="main">
		<section class="blocks">
<?php
	$sites = get_posts( array('post_type'=>'site', 'orderby'=>'post_date', 'numberposts' => -1) );

	foreach($sites as $post) : 
		setup_postdata($post); 
		$site_images = get_posts( array(
			'post_type' => 'attachment',
			'orderby' => 'menu_order',
			'order' => 'asc',
			'posts_per_page' => -1,
			'post_parent' => $post->ID
		));
		$images = array();
		if ( $site_images ) :
			foreach ( $site_images as $img ) :
				$image = wp_get_attachment_image_src( $img->ID, 'thumbnail' );
				$images[] = $image[0];
			endforeach; 
		endif;

		$tags = get_the_tags();
?>
			<article class="block<?php if($tags) { foreach($tags as $tag) { echo strtolower(' '.ltrim($tag->name, '.')); } } ?>">
				<div>
					<h3 class="overlay">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a>
						<?php // the_excerpt() ?>
					</h3>

					<div class="carousel">
<?php /*
						<img class="prev disabled" src="<?php bloginfo('template_url'); ?>/images/util/arrow-left.png" alt="">
						<ul style="">
							<?php foreach ($images as $img) : ?>
							<li><img src="<?php echo $img ?>" alt=""></li>
							<?php endforeach ?>
						</ul>
						<img class="next" src="<?php bloginfo('template_url'); ?>/images/util/arrow-right.png" alt="">
*/?>


<?php 					/* foreach ($images as $img) { echo '<img src="'.$img.'" alt="" />'; } */ ?>


						<?php foreach ($images as $img) { echo '<img class="lazy" src="'.get_bloginfo('template_url').'/images/util/trans.png" data-original="'.$img.'" alt="" />'; } ?>

					</div>
				</div>
    		</article>
<?php 
	endforeach; 
?>
		</section>
	</div>

<?php get_footer(); ?>