<?php get_header(); ?>	


<div id="main_cont">

	<div class="container">

		<div id="cont_left">

			<?php if(is_tax('empresa')) { ?>

			<!-- Título -->
			<div class="archive_title">

				<?php printf( __( '%s', 'twentyten' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>


			</div><!--//archive_title-->
			
			
			<!-- Descrição da pessoa -->
			<?php
				$descricao = term_description();
				if ($descricao) {
					echo '<h2>Descrição</h2>';
					echo '<p>' . $descricao . '</p>';
				}
				
				echo '<br/><br/>';
				echo '<h2>Filmografia</h2>';
// 				echo '<br/><br/>';

			} ?>


			<?php
			global $wp_query;
			
			// Fazendo query de custom post types == filme onde essa pessoa tenha sido referenciada.
			$args_query = array( 
				'post_type'=>array('filme'), 
				'posts_per_page' => -1 
			);
			$args = array_merge( $wp_query->query, $args_query);
			query_posts( $args );        


			$x = 0;

			echo '<ul>';
			while (have_posts()) : the_post(); ?>     


				<div class="post_box">
					
					<li>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					</li>


<!--
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


							<div class="post_meta_right"><a href="<?php the_permalink(); ?>">LEIA MAIS</a></div>


							<div class="clear"></div>


						</div>


					</div>
-->


					<div class="clear"></div>


				</div><!--//post_box-->


			<?php $x++; ?>


			<?php endwhile; ?>
			</ul>
			


		</div><!--//cont_left-->


	


		<?php get_sidebar(); ?>


		


		<div class="clear"></div>


		


	</div><!--//container-->


	


</div><!--//main_cont-->


<?php get_footer(); ?> 