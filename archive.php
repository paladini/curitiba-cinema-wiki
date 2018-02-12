<?php get_header(); ?>	
<div id="main_cont">
	
	<div class="container">
	
		<div id="cont_left">
		
			<?php if(is_category()) { ?>
			<div class="archive_title">
				<?php printf( __( '%s', 'twentyten' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
			</div><!--//archive_title-->
			<?php } ?>		
		
			<?php
			global $wp_query;
			$args = array_merge( $wp_query->query, array( 'posts_per_page' => -1 ) );
			query_posts( $args );        
			$x = 0;
			while (have_posts()) : the_post(); ?>     
				<div class="post_box">
					<div class="left">
						<?php if(get_post_meta( get_the_ID(), 'page_featured_type', true ) == 'youtube') { ?>
							<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo get_post_meta( get_the_ID(), 'page_video_id', true ); ?>" frameborder="0" allowfullscreen></iframe>
						<?php } elseif(get_post_meta( get_the_ID(), 'page_featured_type', true ) == 'vimeo') { ?>
							<iframe src="http://player.vimeo.com/video/<?php echo get_post_meta( get_the_ID(), 'page_video_id', true ); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=085e17" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						<?php } else { ?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-image'); ?></a>
						<?php } ?>											
					</div>
					<div class="right">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo ds_get_excerpt('155'); ?></p>
						<div class="post_meta">
							<div class="post_meta_left"><?php the_time('F d, Y'); ?></div>
							<div class="post_meta_right"><a href="<?php the_permalink(); ?>">READ MORE</a></div>
							<div class="clear"></div>
						</div><!--//post_meta-->
					</div>
					<div class="clear"></div>
				</div><!--//post_box-->
			<?php $x++; ?>
			<?php endwhile; ?>
			
		</div><!--//cont_left-->
	
		<?php get_sidebar(); ?>
		
		<div class="clear"></div>
		
	</div><!--//container-->
	
</div><!--//main_cont-->
<?php get_footer(); ?> 