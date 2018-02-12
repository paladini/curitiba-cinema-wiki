<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8" />

	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title> 

	<?php wp_head(); ?>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<!--	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">-->

	<!--[if lt IE 9]>

	<script src="https://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>

	<![endif]-->              		

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,200' rel='stylesheet' type='text/css' />

	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />	

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" title="no title" charset="utf-8"/>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/mobile.css" type="text/css" media="screen" title="no title" charset="utf-8"/>

	<!--[if IE]>

		<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

	<![endif]-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.infinitescroll.js" type="text/javascript" charset="utf-8"></script>    

	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/scripts.js"></script>

	<?php $shortname = "designer_mag"; ?>

	

	<style type="text/css">

	body {

	<?php if(get_option($shortname.'_background_image_url','') != "") { ?>

		background: url('<?php echo get_option($shortname.'_background_image_url',''); ?>') no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;

	<?php } ?>		

	<?php if(get_option($shortname.'_custom_background_color','') != "") { ?>

		background-color: <?php echo get_option($shortname.'_custom_background_color',''); ?>;

	<?php } ?>	

	}

	</style>		

	

	<script>

	$(document).ready(function() {

		designer_slider('<?php bloginfo('stylesheet_directory'); ?>');

	});

	</script>

	

</head>

<body>

<header id="header">

	<div class="header_top">

		<div class="container">

			<div class="header_menu">

				<?php wp_nav_menu('theme_location=header-menu&container=false&menu_id='); ?>

				<div class="clear"></div>

			</div><!--//header_menu-->

			<div class="header_social">

				<?php if(get_option($shortname.'_twitter_link','') != '') { ?>

					<a href="<?php echo get_option($shortname.'_twitter_link',''); ?>" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter-icon.png" alt="twitter" /></a>

				<?php  } ?>

				<?php if(get_option($shortname.'_facebook_link','') != '') { ?>

					<a href="<?php echo get_option($shortname.'_facebook_link',''); ?>" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook-icon.png" alt="facebook" /></a>

				<?php } ?>

				<?php if(get_option($shortname.'_google_plus_link','') != '') { ?>

					<a href="<?php echo get_option($shortname.'_google_plus_link',''); ?>" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/gplus-icon.png" alt="google plus" /></a>

				<?php } ?>

				<?php if(get_option($shortname.'_instagram_link','') != '') { ?>

					<a href="<?php echo get_option($shortname.'_instagram_link',''); ?>" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/instagram-icon.png" alt="instagram" /></a>

				<?php } ?>

				<?php if(get_option($shortname.'_pinterest_link','') != '') { ?>

					<a href="<?php echo get_option($shortname.'_pinterest_link',''); ?>" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/pinterest-icon.png" alt="pinterest" /></a>

				<?php } ?>

				<?php if(get_option($shortname.'_vimeo_link','') != '') { ?>

					<a href="<?php echo get_option($shortname.'_vimeo_link',''); ?>" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/vimeo-icon.png" alt="vimeo" /></a>

				<?php } ?>

				<?php if(get_option($shortname.'_youtube_link','') != '') { ?>

					<a href="<?php echo get_option($shortname.'_youtube_link',''); ?>" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/youtube-icon.png" alt="youtube" /></a>

				<?php } ?>

			</div><!--//header_social-->

			<div class="clear"></div>

		</div><!--//container-->

	</div><!--//header_top-->

	<div class="logo_cont">

		<div class="container">

			<?php if(get_option($shortname.'_custom_logo_url','') != "") { ?>

				<a href="<?php bloginfo('url'); ?>"><img src="<?php echo get_option($shortname.'_custom_logo_url',''); ?>" alt="logo" class="logo" /></a>

			<?php } else { ?>	

				<a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" alt="logo" class="logo" /></a>

			<?php } ?>		

			<div class="clear"></div>

		</div><!--//container-->

	</div><!--//logo_cont-->

</header><!--//header-->

<?php if (is_home()) { //if(!is_single() && !is_page()) { ?>

<?php if(get_option($shortname.'_disable_slideshow','') != "Yes") { ?>

<div id="slideshow_cont">

	<div class="container">

		<div id="slideshow">

			<?php

			global $slider_arr;

			$slider_arr = array();

			$x = 0;

			$args = array(

				 //'category_name' => 'blog',

				 'post_type' => 'post',

				 'meta_key' => 'ex_show_in_slideshow',

				 'meta_value' => 'Yes',

				 'posts_per_page' => 5

				 );

			query_posts($args);

			while (have_posts()) : the_post(); ?>      

			

				<div class="slide_box <?php if($x == 0) { echo 'slide_box_first'; } ?>">

				

				<?php if(get_post_meta( get_the_ID(), 'page_featured_type', true ) == 'youtube') { ?>

					<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo get_post_meta( get_the_ID(), 'page_video_id', true ); ?>" frameborder="0" allowfullscreen></iframe>

					<div style="display: none !important;"><?php the_post_thumbnail('slideshow-image'); ?></div>

				<?php } elseif(get_post_meta( get_the_ID(), 'page_featured_type', true ) == 'vimeo') { ?>

					<iframe src="https://player.vimeo.com/video/<?php echo get_post_meta( get_the_ID(), 'page_video_id', true ); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=085e17" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>

					<div style="display: none !important;"><?php the_post_thumbnail('slideshow-image'); ?></div>

				<?php } else { ?>				

					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('slideshow-image'); ?></a>

				<?php } ?>

				

				</div>

			

			<?php array_push($slider_arr,get_the_ID()); ?>

			<?php $x++; ?>

			<?php endwhile; ?>

			<?php wp_reset_query(); ?>    			

			

		</div><!--//slideshow-->

		<div class="slide_thumbs_cont">

		</div><!--//slide_thumbs_cont-->

	</div><!--//container-->

</div><!--//slideshow_cont-->

<?php } ?>

<?php } ?>