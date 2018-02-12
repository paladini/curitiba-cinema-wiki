<?php get_header(); ?>	


<div id="main_cont">

	<div class="container">

		<div id="cont_left">


			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<h1 class="single_title"><?php the_title(); ?></h1>
					<div class="single_inside_content">
						<?php the_content(); ?>
					</div><!--//single_inside_content-->
	
					<br /><br />
	
					<div class="next_prev_cont">
	
						<div class="left">
							 <?php previous_post_link('%link', '<i>Previous post</i><br />%title'); ?> 
						</div>
	
						<div class="right">
							 <?php next_post_link('%link', '<i>Next post</i><br />%title'); ?> 
						</div>
	
						<div class="clear"></div>
	
					</div><!--//next_prev_cont-->
	
	
					
	
	
					<?php comments_template(); ?>							
	
	
					
	
	
					
	
	
					
	
	
					<div class="you_may_like">YOU MAY LIKE</div>
	
	
					
	
	
					<?php
	
	
					$args = array(
	
	
						 'post_type' => 'post',
	
	
						 'posts_per_page' => 3,
	
	
						 'orderby' => 'rand'
	
	
						 );
	
	
					query_posts($args);
	
	
					$x = 0;
	
	
					while (have_posts()) : the_post(); ?>            				
	
	
					
	
	
						<div class="may_like_box <?php if($x == 2) { echo 'may_like_box_last'; } ?>">
	
	
							<?php if(get_post_meta( get_the_ID(), 'page_featured_type', true ) == 'youtube') { ?>
	
	
								<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo get_post_meta( get_the_ID(), 'page_video_id', true ); ?>" frameborder="0" allowfullscreen></iframe>
	
	
							<?php } elseif(get_post_meta( get_the_ID(), 'page_featured_type', true ) == 'vimeo') { ?>
	
	
								<iframe src="http://player.vimeo.com/video/<?php echo get_post_meta( get_the_ID(), 'page_video_id', true ); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=085e17" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	
	
							<?php } else { ?>
	
	
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('may-like-image'); ?></a>
	
	
							<?php } ?>							
	
	
							
	
	
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	
	
						</div><!--//may_like_box-->
	
	
					
	
	
					<?php $x++; ?>
	
	
					<?php endwhile; ?>
	
	
					<?php wp_reset_query(); ?>   	
	
	
					<div class="clear"></div>


				


			<?php endwhile; else: ?>


			


				<h3>Sorry, no posts matched your criteria.</h3>


			<?php endif; ?>                    												


			


		</div><!--//cont_left-->


	


		<?php get_sidebar(); ?>


		


		<div class="clear"></div>


		


	</div><!--//container-->


	


</div><!--//main_cont-->


<?php get_footer(); ?> 