<?php get_header(); ?>
  
	<div id="main" class="codes">
		<section class="blocks">
<?php
	// $codes = get_posts( array('post_type'=>'code', 'numberposts' => -1) );

	global $wpdb;
	$query = "SELECT terms.* FROM $wpdb->term_taxonomy tax LEFT JOIN $wpdb->terms terms ON tax.term_id = terms.term_id WHERE tax.taxonomy = 'code_type'";
	$categories = $wpdb->get_results($query, OBJECT);	// these are all the "categories" of our custom post_type's taxonomy

	foreach( $categories as $cat ) : ?>
		<article class="block half">
			<h2><?php echo $cat->name ?></h2>
			<ul><?php
				$posts = get_posts( array( 'code_type' => $cat->slug, 'post_type' => 'code', 'numberposts' => -1 ) );
				foreach($posts as $post) : 
					setup_postdata($post); 
					$gist = get_post_meta($post->ID, 'gist', true);
					// $type = strpos($gist, 'gist') ? 'gist' : (strpos($gist, 'wordpress') ? 'wordpress' : 'coming soon');
					$type = '';
					?>
					<li>
						<h3><?php the_title(); ?></h3>
						<?php the_content(); ?>
						<h6><?php echo $type ?> <a href="<?php echo $gist ?>"><?php echo $gist ?></a></h6>
					</li><?php
				endforeach; ?>
			</ul>
		</article><?php
	endforeach;

/*
	foreach($codes as $post) : 
		setup_postdata($post); ?> 

		<article>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</article>

		<?php
	endforeach;
*/

?>

		</section>
	</div>

<?php get_footer(); ?>