<?php get_header(); ?>	


<div id="main_cont">

	<div class="container">

		<div id="cont_left">


			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<h1 class="single_title"><?php the_title(); ?> (Sala de Cinema)</h1>
					<div class="single_inside_content">
						
						<?php 
						
						function pega_taxonomias($taxonomy_obj_array) {
							$term = "";
							if ( is_array($taxonomy_obj_array) ) {
								foreach($taxonomy_obj_array as $v) {
									$term .= '<a href="'. get_term_link($v).'">' . $v->name . '</a>, ';
								}
								$term = substr($term, 0, -2);	
							} elseif ((!is_bool($taxonomy_obj_array)) && get_class($taxonomy_obj_array) == "WP_Term") {
								$term .= '<a href="'. get_term_link($taxonomy_obj_array).'">' . $taxonomy_obj_array->name . '</a>';
							}
							return $term;
						}
						
						function verifica_se_tem_valor($field) {
							
							if ($field['type'] == 'group') {
								$campo1 = $field['name'] . '_' . $field['sub_fields'][0]['name'];
								$campo2 = $field['name'] . '_' . $field['sub_fields'][1]['name'];
								
								if (get_field($campo1) || get_field($campo2))
									return True;
								else
									return False;
								
							} elseif ($field['type'] == 'text' || $field['type'] == 'textarea') {
								$texto = get_field($field['name']);
								if ($texto && $texto != '' && trim($texto) != '')
									return True;
								else
									return False;
							} else {
								if (get_field($field['name']))
									return True;
								else
									return False;
							}
						}
						
						echo '<br/>';
						
						// Imagem (se houver)
						$imagem1 = get_field('arquivo_de_midia_logomarca');
						if ($imagem1) {
							echo '<br/>';
							echo '<img src="'. $imagem1["url"] .
								'" height="300" style="text-align: center; margin: 0 auto; display: block; float: none;"/>';
							echo '<br/>';
						}
						
						// Detalhes
						echo '<p style="text-align: justify;">';
						
						// PRIMEIRA LINHA
						$mantenedora = get_field('mantenedora');
						$proprietarios = get_field('proprietarios_pessoa_fisica');
						$tipo_de_cinema = get_field('tipo_de_cinema');
						$inauguracao = get_field('data_da_primeira_sessao');
						$data_ultima_sessao = get_field('data_da_ultima_sessao');
						$tem_valor = False;
						
						if ($mantenedora) {
							$tem_valor = True;
							echo 'Mantenedora: <b>'. pega_taxonomias($mantenedora) .'</b>';
						}
						
						if ($proprietarios) {
							if ($tem_valor)
								echo ' | ';
							$tem_valor = True;
							echo 'Proprietários: <b>'. pega_taxonomias($proprietarios) . '</b>';
						}
						
						if ($tipo_de_cinema) {
							if ($tem_valor)
								echo ' | ';
							$tem_valor = True;
							echo 'Tipo de Cinema: <b>'. pega_taxonomias($tipo_de_cinema) .'</b>';
						}
						
						if ($inauguracao) {
							if ($tem_valor)
								echo ' | ';
							$tem_valor = True;
							echo 'Inauguração: <b>' . $inauguracao . '</b>';
						}
						
						if ($data_ultima_sessao) {
							if ($tem_valor)
								echo ' | ';
							$tem_valor = True;
							echo 'Data da última sessão: <b>' . $data_ultima_sessao . '</b>';
						}
							
						
						if ($mantenedora || $proprietarios || $tipo_de_cinema || $inauguracao || $data_ultima_sessao)
							echo '</br></br>';
						
						
						// SEGUNDA LINHA
						$site = get_field('site_oficial_eou_perfis_em_redes_sociais');
						if ($site)
							echo 'Site: <b><a href="'. $site .'">' . $site . '</a></b>';
						
						if (get_field('logradouro_da_sala_de_cinema_endereco')) {
							if ($site)
								echo ' | ';
							
							echo '<b>Endereço</b><br/>';
							echo get_field('logradouro_da_sala_de_cinema_endereco');
							
							if (get_field('logradouro_da_sala_de_cinema_cidade'))
								echo ' - ' . get_field('logradouro_da_sala_de_cinema_cidade');
								
							if (get_field('logradouro_da_sala_de_cinema_estado'))
								echo ' (' . get_field('logradouro_da_sala_de_cinema_estado') . ').';
								
							if (get_field('logradouro_da_sala_de_cinema_cep_codigo_postal'))
								echo ' CEP ' . get_field('logradouro_da_sala_de_cinema_cep_codigo_postal');
							
						}
						
						if ($site || get_field('logradouro_da_sala_de_cinema_endereco'))
							echo '<br/><br/>';
							
						// Histórico
						$historico = get_field('historico');
						if ($historico) {
							echo '</br></br>';
							echo '<h2>Histórico</h2>';
							echo $historico;
						}
						
						// Galeria
						$imagem1 = get_field('arquivo_de_midia_logomarca');
						
						if ($imagem1) {
							echo '<h2 style="text-align: center;">Galeria</h2><br/>';
							echo '<img src="'. $imagem1["url"] .
								'" height="300" style="text-align: center; margin: 0 auto; display: block; float: none;"/>';
							echo '<br/>';
						}	
						
						echo '</p>';
						
						?>
												
						<?php the_content(); ?>
					</div><!--//single_inside_content-->
	
					<br /><br />	
	
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