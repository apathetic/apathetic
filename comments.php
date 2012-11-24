<?php
/**
 * @package WordPress
 * @subpackage CSTW
 */

if ( post_password_required() ) : ?>
<p><?php _e('Enter your password to view comments.'); ?></p>
<?php return; endif; ?>

<h2 id="comments"><?php comments_number(__('0 Response'), __('1 Response'), __('% Response')); ?> to &ldquo;<?php single_post_title(); ?> &rdquo;</h2>

<?php if ( $comments ) : ?>
<div id="commentlist">

<?php foreach ($comments as $comment) : ?>
	<div <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
    
    <div class="comment_meta">
    	<span class="comment_author"><?php comment_author_link() ?></span><br />
        <span class="comment_time"><?php comment_date() ?><br /><?php comment_time() ?></span><br />
        <?php echo get_avatar( $comment, 96 ); ?>
    </div>
    <div class="comment_entry">
    <div><?php comment_type(_c('Comment|noun'), __('Trackback'), __('Pingback')); ?> :</div>
	<?php comment_text() ?>
    </div>
    <div class="clear"></div>

	</div>

<?php endforeach; ?>

</div>

<?php else : // If there are no comments yet ?>
	<p><?php _e('No comments yet.'); ?></p>
<?php endif; ?>

<p style="font-size: 80%;font-family: Arial, Helvetica, sans-serif;"><?php post_comments_feed_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.')); ?>
<?php if ( pings_open() ) : ?>
	<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Universal Resource Locator">URL</abbr>'); ?></a>
<?php endif; ?>
</p>

<?php if ( comments_open() ) : ?>
<h2 id="postcomment"><?php _e('Leave a comment'); ?></h2>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php printf(__('Logged in as %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account') ?>"><?php _e('Log out &raquo;'); ?></a></p>

<?php else : ?>

<p><label for="author"><small><?php _e('Name'); ?> <?php if ($req) _e('(required)'); ?></small></label><br /><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
</p>

<p><label for="email"><small><?php _e('Email (will not be published)');?> <?php if ($req) _e('(required)'); ?></small></label><br /><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
</p>

<p><label for="url"><small><?php _e('Website'); ?></small></label><br /><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
</p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> <?php printf(__('You can use these tags: %s'), allowed_tags()); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="50%" rows="10" tabindex="4"></textarea></p>


<div style="margin: 20px 0;">
<?php do_action('comment_form', $post->ID); ?>
</div>

<p style="margin: 10px 0 !important;"><input name="commentsubmit" type="submit" id="commentsubmit" tabindex="5" value="<?php echo attribute_escape(__('Submit Comment')); ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<p>If you&rsquo;d like a picture to show up by your name, <a href="http://en.gravatar.com/" target="_blank">get a Gravatar</a>.</p>
</form>

<?php endif; // If registration required and not logged in ?>

<?php else : // Comments are closed ?>
<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
<?php endif; ?>
