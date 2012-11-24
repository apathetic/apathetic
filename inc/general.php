<?php

// -------------------------------------
//	Enable/Disable WordPress stuff
// -------------------------------------

	// remove junk from head
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

	// add post thumbnail support + custom menu support
	add_theme_support('post-thumbnails');
	add_theme_support('nav-menus');
	
	// remove unwanted core dashboard widgets
	function rm_dashboard_widgets() {
		global $wp_meta_boxes;
		// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);		// right now [content, discussion, theme, etc]
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);			// plugins
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);	// incoming links
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);			// wordpress blog
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);			// other wordpress news
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);		// quickpress
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);		// drafts
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);	// comments
	}
	add_action('wp_dashboard_setup', 'rm_dashboard_widgets' );

	// manage backend items
	function manage_menu_items() {
		remove_menu_page('link-manager.php');
		remove_menu_page('edit-comments.php');
	}
	add_action('admin_menu', 'manage_menu_items', 99);

	function load_styles() {
		echo '<style>#login{ padding-top:64px; } #login h1 a { background:transparent url("'.get_bloginfo('template_url').'/images/admin/wesley.png") 50% 0 no-repeat; height:300px; padding:0; }</style>'."\n";
	}
	add_action('login_head', 'load_styles');

	// add parent class to menu item with children
	function add_parent_class( $css_class, $page, $depth, $args ) {
		if ( ( $args['has_children'] ) ) 
			$css_class[] = 'parent';
		return $css_class;
	}
	add_filter( 'page_css_class', 'add_parent_class', 10, 4 );


// -------------------------------------
//	Misc
// -------------------------------------
	
	
	// make cleaner better permalink urls
	function url_cleaner_clean($slug) {
		// remove everything except letters, numbers and -
		$pattern = '~([^a-z0-9\-])~i';
		$replacement = '';
		$slug = preg_replace($pattern, $replacement, $slug);
	
		// when more than one - , replace it with one only
		$pattern = '~\-\-+~';
		$replacement = '-';
		$slug = preg_replace($pattern, $replacement, $slug);
	
		return $slug;
	}
	// add_filter('editable_slug', 'url_cleaner_clean');



?>