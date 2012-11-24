<?php get_header(); ?>
  
	<div class="main">
  
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>

	<?php endwhile; else: ?>

		<h3>Sorry, no posts matched your criteria.</h3>

	<?php endif; ?>
  
	</div>

<?php get_footer(); ?>