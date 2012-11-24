  <div class="left_container">
    
    <?php if(is_category()) { ?>
    <div class="left_box">
      <h3><?php single_cat_title(); ?></h3>
      
      <ul>
        
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        
        <?php endwhile; else: ?>

          <h3>Sorry, no posts matched your criteria.</h3>
    
        <?php endif; ?>
      </ul>
      
    </div><!--//left_box-->
    <?php } ?>
  
  
    <div class="left_box">
      <h3>Portfolio</h3>
      
      <ul>
        <?php
         global $post;
         $myposts = get_posts('numberposts=25&category_name=Portfolio');
         foreach($myposts as $post) :
           setup_postdata($post);
         ?>
        
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        
        <?php endforeach; ?>
        <?php //wp_list_categories('title_li=&hierarchical=0'); ?>
      </ul>
      
    </div><!--//left_box-->
    
    
    <div class="left_box">
      <h3 class="bottom_line">About</h3>
      
      Wes Hatch<br />
      Programmer/Designer<br />
      Born in Canada<br />
      Living in Montreal<br />
      <br />
      Expert in web design &amp;<br />
      user interface. Illustrations<br />
      design, focus on font and<br />
      usability.
      <br />
    </div><!--//left_box-->
    
    
    <div class="left_box">
      <h3 class="bottom_line">Contact</h3>
      
      Wes Hatch<br />
      <a href="mailto:wes.hatch@gmail.com">wes.hatch@gmail.com</a><br />
    </div><!--//left_box-->
  
  </div><!--//left_container-->
