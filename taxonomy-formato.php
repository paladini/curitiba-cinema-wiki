<?php get_header(); ?>	


<div id="main_cont">

	<div class="container">

		<div id="cont_left">

			<?php if(is_tax('formato')) { ?>

			<!-- Título -->
			<div class="archive_title">

				<?php printf( __( '%s', 'twentyten' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>


			</div><!--//archive_title-->
			
			
			<!-- Descrição da pessoa -->
			<?php
/*
				$descricao = term_description();
				if ($descricao) {
					echo '<h2>Descrição</h2>';
					echo '<p>' . $descricao . '</p>';
				}
				
				echo '<br/><br/>';
				echo '<h2>Filmografia</h2>';
*/
// 				echo '<br/><br/>';

			} ?>


			<?php
			global $wp_query;
			
			$queried_object = get_queried_object();
			$term_slug = $queried_object->term_slug;
			$taxonomy = 'formato';
			$taxonomy_terms = get_terms( $taxonomy, array(
			    'hide_empty' => 0,
			    'fields' => 'ids'
			) );
			
			// Fazendo query de custom post types == filme onde essa pessoa tenha sido referenciada.
			$args_query = array( 
				'post_type'=>array('filme'), 
				'posts_per_page' => -1 ,
				'fields'         => 'ids',
				'tax_query' => array(
			        array(
			            'taxonomy' => $taxonomy,
			            'terms' => $taxonomy_terms,
			            'field' => 'id',
			        )
			    )
			);
			$args = array_merge( $wp_query->query, $args_query);
			query_posts( $args );        


			$x = 0;

// 			echo '<ul>';
// 			while (have_posts()) : the_post(); 
			foreach ($posts as $post) {
			?>     

				<div class="post_box">


					<div class="left">


						<?php if(get_post_meta( $post->ID , 'page_featured_type', true ) == 'youtube') { ?>


							<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo get_post_meta( get_the_ID(), 'page_video_id', true ); ?>" frameborder="0" allowfullscreen></iframe>


						<?php } elseif(get_post_meta( $post->ID , 'page_featured_type', true ) == 'vimeo') { ?>


							<iframe src="http://player.vimeo.com/video/<?php echo get_post_meta( $post->ID , 'page_video_id', true ); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=085e17" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>


						<?php } else { ?>


							<a href="<?php echo get_permalink( $post->ID ); // the_permalink(); ?>" style="display: block !important; text-align: center !important;">
								<?php 
									$src = get_the_post_thumbnail_url($post->ID, 'post-image');
									if (empty($src)) {
										$src = "/wp-content/uploads/2018/02/movie-icon-14032.png";
									}
								?>
								<div class="container-search">
									<div class="tag-search">
										<?php 
											$tipo = ucfirst(get_post_type($post->ID)); 
											if ($tipo == 'Page') {
												$tipo = 'Página';
											} elseif ($tipo == 'Post') {
												$tipo = 'Blog';
											}
											
											echo $tipo;
										?>
									</div>
									<img src="<?php echo $src; ?>" 
										alt="<?php echo get_the_title( $post->ID ); ?>" 
										title="<?php echo get_the_title( $post->ID ); ?>"
										class="attachment-post-image default-featured-img"
										style="float: none !important; display: inline !important; width: auto !important;"
										height="240">
								</div>
							</a>


						<?php } ?>											


					</div>


					<div class="right">


						<h3><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h3>


						<p><?php echo custom_field_excerpt(); ?></p>


						<div class="post_meta">


							<div class="post_meta_left"><?php the_time('F d, Y'); ?></div>


							<div class="post_meta_right"><a href="<?php echo get_permalink( $post->ID ); ?>">LEIA MAIS</a></div>


							<div class="clear"></div>


						</div><!--//post_meta-->


					</div>


					<div class="clear"></div>


				</div><!--//post_box-->
<!--
				<div class="post_box">
					
					<li>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					</li>
-->


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


<!--
					<div class="clear"></div>


				</div>
--><!--//post_box-->


			<?php $x++; ?>


			<?php } ?>
<!-- 			</ul> -->
			


		</div><!--//cont_left-->


	


		<?php get_sidebar(); ?>


		


		<div class="clear"></div>


		


	</div><!--//container-->


	


</div><!--//main_cont-->


<?php get_footer(); ?> 