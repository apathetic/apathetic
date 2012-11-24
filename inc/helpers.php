<?php


function register_menus() {
  register_nav_menus(
    array( 'main-menu' => __( 'Main Menu' ), 'footer-menu' => __( 'Footer Menu' ))
  );
}
add_action( 'init', 'register_menus' );

function new_excerpt_length($length) {
	global $post;
	if(function_exists('tribe_is_event') && tribe_is_event($post->ID)) {
		return 32;
	} else {
		return 55;
	}
}
add_filter('excerpt_length', 'new_excerpt_length');



// ------------- CONTENT STUFF --------------//

function cdmn_excerpt($length=55) {
	$text = get_the_content('');

	$text = strip_shortcodes( $text );

	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
//	$excerpt_length = apply_filters('excerpt_length', $length);
	$excerpt_length = $length;
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );

	echo '<p>' . apply_filters('wp_trim_excerpt', $text, '') . '</p>';
}

function list_sponsors($show_class=false, $order='rand') {
	$class = ($show_class) ? ' class="sponsors rowify"' : '';
	echo '<ul'. $class .'>';

 	$sponsors = get_posts( array('post_type'=>'sponsor', 'orderby' => $order, 'order'=> 'ASC', 'numberposts'=> -1 ));
	foreach($sponsors as $sponsor) : setup_postdata($sponsor);
		$img_url = wp_get_attachment_image_src( get_post_thumbnail_id($sponsor->ID), 'fullsize'); 
		if ($img_url) { echo '<li><img src="'. $img_url[0] .'" alt="" /></li>'; }
		else { echo '<li>'.getImage(1).'</li>'; }
	endforeach;
	echo '</ul>';

}

function setup_social() {
	?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php
}

function social_buttons($float=false) { ?>
	<div>
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>" data-text="<?php the_title() ?>">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
	<div>
		<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
		<script type="IN/Share" data-url="<?php the_permalink() ?>" data-counter="right"></script>
	</div>
	<div>
		<div class="fb-like" data-href="<?php the_permalink() ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
	</div>
<?php
}





// ------------- COMMENTS --------------//

function cdmn_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	    case 'pingback' :
	    case 'trackback' :
	?>
	<li class="post pingback">
	    <p>Pingback: <?php comment_author_link(); ?><?php edit_comment_link('Edit', '<span class="edit-link">', '</span>' ); ?></p>
	<?php
	        break;
	    default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	    <article id="comment-<?php comment_ID(); ?>" class="comment">
	        <footer class="comment-meta">
	            <div class="comment-author vcard">
	                <?php
	                    $avatar_size = 68;
	                    if ( '0' != $comment->comment_parent )
	                        $avatar_size = 39;
	
	                    echo get_avatar( $comment, $avatar_size );
	
	                    /* translators: 1: comment author, 2: date and time */
	                    printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
	                        sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
	                        sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
	                            esc_url( get_comment_link( $comment->comment_ID ) ),
	                            get_comment_time( 'c' ),
	                            /* translators: 1: date, 2: time */
	                            sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
	                        )
	                    );
	                ?>
	
	                <?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
	            </div><!-- .comment-author .vcard -->
	
	            <?php if ( $comment->comment_approved == '0' ) : ?>
	                <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
	                <br />
	            <?php endif; ?>
	
	        </footer>
	
	        <div class="comment-content"><?php comment_text(); ?></div>
	
	        <div class="reply">
	            <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'twentyeleven' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	        </div><!-- .reply -->
	    </article><!-- #comment-## -->
	
	<?php
	        break;
	endswitch;
}

function cdmn_sidebar_comments($comment, $args, $depth) { 
	$GLOBALS['comment'] = $comment; 
	extract($args, EXTR_SKIP); ?> 
	<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>"> 

	<?php if ($comment->comment_approved == '0') : ?> 
	  <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em><br /> 
	<?php endif; ?> 
	 
	<div class="comment-meta"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><br /> 
	<span class="comment-author vcard"><?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?></span></div> 
	<?php comment_text() ?>
	<div class="edit-reply"><?php edit_comment_link(__('Edit'),'  ','' ); ?><?php if(current_user_can('edit_posts')) { echo ' / '; } ?><span class="reply"><?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span></div>
	
<?php 
}


// ------------- IMAGE STUFF --------------//

function getImage($num) {	// ha ha, from c. bavota
	global $more;
	$more = 1;
	$content = get_the_content();
	$count = substr_count($content, '<img');
	$start = 0;
	for($i=1; $i<=$count;$i++) {
		$imgBeg = strpos($content, '<img', $start);
		$post = substr($content, $imgBeg);
		$imgEnd = strpos($post, '>');
		$postOutput = substr($post, 0, $imgEnd+1);
		$postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', '', $postOutput);;
		$image[$i] = $postOutput;
		$start=$imgEnd+1;
	}
	if(stristr($image[$num],'<img')) { echo $image[$num]; }
	$more = 0;
}







function encode_image( $filename=string, $filetype=string ) {
    if ($filename) {
        $img = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($img);
    }
}














add_filter( 'locale', 'my_theme_localized' );
function my_theme_localized($locale) {
	if (isset($_GET['l'])) {
		return $_GET['l'];
	}
	return $locale;
}


$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if ( is_readable( $locale_file) ) 
	require_once( $locale_file);


