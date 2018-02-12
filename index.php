<?php get_header(); ?>	
<script type="text/javascript">
$(document).ready(
function($){
  $('#posts_cont').infinitescroll({
 
    navSelector  : "div.load_more_text",            
		   // selector for the paged navigation (it will be hidden)
    nextSelector : "div.load_more_text a:first",    
		   // selector for the NEXT link (to page 2)
    itemSelector : "#posts_cont .post_box"
		   // selector for all items you'll retrieve
  },function(arrayOfNewElems){
  
      //$('.home_post_cont img').hover_caption();
 
     // optional callback when new content is successfully loaded in.
 
     // keyword `this` will refer to the new DOM content that was just added.
     // as of 1.5, `this` matches the element you called the plugin on (e.g. #content)
     //                   all the new elements that were found are passed in as an array
 
  });  
}  
);
</script>	
<div id="main_cont">
	
	<div class="container">
	
		<div id="cont_left">
		
			<div id="posts_cont">
		
				<?php
				//$category_ID = get_category_id('blog');
				global $slider_arr;
				//print_r($slider_arr);
				if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) {
					$args = array(
						 'post_type' => 'post',
						 'posts_per_page' => -1,
						 'post__not_in' => $slider_arr,
						 'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1)
						 //'cat' => '-' . $category_ID
						 );
					query_posts($args);
				} else {
					$args = array(
						 'post_type' => 'post',
						 'posts_per_page' => 5,
						 'post__not_in' => $slider_arr,
						 'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1)
						 //'cat' => '-' . $category_ID
						 );
					query_posts($args);				
				}
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
							<p><?php echo ds_get_excerpt('130'); ?></p>
							<div class="post_meta">
								<div class="post_meta_left"><?php the_time('F d, Y'); ?></div>
								<div class="post_meta_right"><a href="<?php the_permalink(); ?>">READ MORE</a></div>
								<div class="clear"></div>
							</div><!--//post_meta-->
						</div>
						<div class="clear"></div>
					</div><!--//post_box-->
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>     
				
			</div><!--//posts_cont-->
			<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) { ?>
			
			<?php } else { ?>
			<div class="load_more_cont">
				<div align="center"><div class="load_more_text">
				<?php
				ob_start();
				next_posts_link('<img src="' . get_bloginfo('stylesheet_directory') . '/images/loading-button.png" />');
				$buffer = ob_get_contents();
				ob_end_clean();
				if(!empty($buffer)) echo $buffer;
				?>
				</div></div>
			</div><!--//load_more_cont-->             

   			
			<?php } ?>
		</div><!--//cont_left-->
	
		<?php get_sidebar(); ?>
		
		<div class="clear"></div>
		
	</div><!--//container-->
	
</div><!--//main_cont-->
<?php get_footer(); ?> 