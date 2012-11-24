<?php
$titles = array(
	'the eye of the tiger',
	'Home of the NAILZ',
	'Web crafter extraordinaire',
	'Detail oriented and amazement warranted',
	'Nice to meet you',
	'powered by PHANTEX',
	'"Tout le monde m\'adore"',
	'Now with extra zing',
	'neither young nor ambitious nor creative'
);
$rand = rand( 0, count($titles)-1 );
$notfunny = $titles[$rand];
?><!doctype html>  

<html <?php language_attributes(); ?>>
<head>		
<title>a.k.a. wes hatch</title>
<?php wp_head(); ?>
<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="<?php echo get_bloginfo('template_url') ?>/js/selectivizr.js"></script>
<![endif]-->
</head>

<body>

	<div id="container" class="page-curl">

		<header>
			<h1><a href="/">apathetic</a></h1>
			<p><?php echo $notfunny ?></p>
			<nav><ul><?php wp_list_pages( array('title_li'=>'') ); ?></ul></nav>
		</header>