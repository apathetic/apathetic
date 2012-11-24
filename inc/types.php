<?php

if ( function_exists( 'sld_register_post_type' ) ) {

	sld_register_post_type( 'site', array( 'supports' => array( 'title', 'editor', 'thumbnail' ), 'taxonomies' => array('post_tag'), 'custom_icon' => 'rectangles' ) );
	sld_register_post_type( 'code', array( 'supports' => array( 'title', 'editor' ), 'custom_icon' => 'star' ), 'Code' );
	sld_register_taxonomy( 'code_type', 'code', 'Code Type', array( 'rewrite' => array( 'slug' => 'code' ) )  );

}


add_action( 'admin_init', 'apathetic_custom_fields');
function apathetic_custom_fields() {
	if ( !function_exists('x_add_metadata_group')) return; // let's not get ourselves locked out of the site

	/* sites */
	x_add_metadata_group( 'site_details', 'site', array('label' => 'Site Details', 'priority' => 'high' ) );
	x_add_metadata_field( 'year',		'site', array( 'group' => 'site_details', 'label' => 'Year' ) );
	x_add_metadata_field( 'client',		'site', array( 'group' => 'site_details', 'label' => 'Client' ) );
	x_add_metadata_field( 'URL',		'site', array( 'group' => 'site_details', 'label' => 'URL', 'field_type' => 'text' ) );

	/* snippets */
	x_add_metadata_group( 'code_details', 'code', array('label' => 'Details', 'priority' => 'high' ) );
	x_add_metadata_field( 'gist',	 		'code', array( 'group' => 'snippet_details', 'label' => 'gist URL' ) );


}

add_filter( 'manage_edit-site_columns', 'edit_site_columns' ) ;
function edit_site_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Site Name' ),
		'year' => __( 'Year' ),
		'tags' => __( 'Tags' ),
		'date' => __( 'Date' )
	);
	return $columns;
}

add_action( 'manage_site_posts_custom_column', 'manage_site_columns', 10, 2 );
function manage_site_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'year' :
			$year = get_post_meta( $post_id, 'year', true );
			if ( empty( $year ) )
				echo '---';
			else
				// echo $year;
			break;

		// case 'tags' :
		// 	$tags = get_the_terms( $post_id, 'post_tag' );
		// 	if ( empty( $year ) )
		// 		echo '---';
		// 	else
		// 		echo implode(', ', $tags);
		// 	break;

		default :
			break;
	}

}

add_filter( 'manage_edit-site_sortable_columns', 'site_sortable_columns' );
function site_sortable_columns( $columns ) {
	$columns['year'] = 'year';
	return $columns;
}

add_action( 'load-edit.php', 'site_columns_load' );
function site_columns_load() {
	add_filter( 'request', 'sort_site_columns' );
}
function sort_site_columns( $vars ) {
	/* Check if we're viewing the 'movie' post type. */
	if ( isset( $vars['post_type'] ) && 'site' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'duration'. */
		if ( isset( $vars['orderby'] ) && 'year' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'year',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}

	return $vars;
}

