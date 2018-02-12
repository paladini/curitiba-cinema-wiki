<?php get_header(); ?>	


<div id="main_cont">

	<div class="container">

		<div id="cont_left">


			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<h1 class="single_title"><?php the_title(); ?> (Iniciativa de Formação)</h1>
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
						$mantenedora_pf = get_field('mantenedora_pf');
						$mantenedora_pj = get_field('mantenedora_pj');
						$inauguracao = get_field('data_de_fundacao');
						$encerramento = get_field('data_de_fechamento_eou_encerramento');
						$cidade = get_field('cidade_de_origem');
						$tipologia = get_field('tipo_de_curso');
						$tem_valor = False;
						
						if ($mantenedora_pf) {
							$tem_valor = True;
							echo 'Mantenedora: <b>'. pega_taxonomias($mantenedora_pf) . '</b>';
							if ($mantenedora_pj)
								echo '<b>, ' . $mantenedora_pj . '</b>';
						}
						
						if ($inauguracao) {
							if ($tem_valor)
								echo ' | ';
							$tem_valor = True;
							echo 'Fundação: <b>' . $inauguracao . '</b>';
						}
						
						if ($encerramento) {
							if ($tem_valor)
								echo ' | ';
							$tem_valor = True;
							echo 'Encerramento: <b>' . $encerramento . '</b>';
						}
						
						if ($cidade) {
							if ($tem_valor)
								echo ' | ';
							$tem_valor = True;
							echo 'Cidade: <b>' . pega_taxonomias($cidade) . '</b>';
						}
						
						if ($tipologia) {
							if ($tem_valor)
								echo ' | ';
							$tem_valor = True;
							echo 'Tipologia: <b>' . pega_taxonomias($tipologia) . '</b>';
						}
							
						
						if ($mantenedora_pf || $mantenedora_pj || $cidade || $tipologia || $inauguracao || $encerramento)
							echo '</br></br>';
						
						
						// SEGUNDA LINHA
						$site = get_field('site_oficial_eou_perfis_em_redes_sociais');
						if ($site)
							echo 'Site: <b><a href="'. $site .'">' . $site . '</a></b>';
						
						if (get_field('sede_ou_campus_endereco')) {
							if ($site)
								echo ' | ';
							
							echo '<b>Sede: </b>';
							echo get_field('sede_ou_campus_endereco');
							
							if (get_field('sede_ou_campus_cidade'))
								echo ' - ' . get_field('sede_ou_campus_cidade');
								
							if (get_field('sede_ou_campus_estado_cidade'))
								echo ' (' . get_field('sede_ou_campus_estado_cidade') . ').';
								
							if (get_field('sede_ou_campus_cep_codigo_postal'))
								echo ' CEP ' . get_field('sede_ou_campus_cep_codigo_postal');
							
						}
							
						// Histórico
						$historico = get_field('historico');
						if ($historico) {
							echo '</br></br>';
							echo '<h2>Histórico</h2>';
							echo $historico;
						}
						
						// Missão Educacional
						$missao_educacional = get_field('missao_academica_eou_educacional');
						if ($missao_educacional) {
							echo '</br></br>';
							echo '<h2>Missão Educacional</h2>';
							echo $missao_educacional;
						}
						
						// Curriculo (curriculo_eou_proposta_de_cursos_livres_ou_atividades_correlatadas)
						$curriculo = get_field('curriculo_eou_proposta_de_cursos_livres_ou_atividades_correlatadas');
						if ($curriculo) {
							echo '<br/>';
							echo 'Currículo: <b>' . $curriculo . '</b>';
						}
						
						// Corpo Docente
						$corpo_docente = get_field('corpo_docente');
						if ($corpo_docente) {
							echo '</br></br>';
							echo 'Corpo Docente: <b>' . $corpo_docente . '</b>';
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
/*
							$fields = get_fields();
							
							if ($fields) {
								
								$i = 0;
								echo '<p>';
								
								foreach ( $fields as $key => $value ) {
									
									// Ignora os campos de preenchimento da ficha padrão, como nome de quem preencheu a ficha, telefone de quem preencheu a ficha, etc.
									if ($i > 2) {
										
										$key_obj = get_field_object($key);
										$label = substr($key_obj['label'], 7);
										
										// Verificando o tipo do campo (se é array ou não).
										$valor_final = '';
										if (is_array( $value )) {
											foreach ( $value as $v ) {
												$valor_final += $v . ', ';
											}
											$valor_final = substr($valor_final, 0, -2);
										} else {
											$valor_final = $value;
										}
										
										// Se tiver algum valor no campo, só então exibe na página
										if ($valor_final) {
											echo '<b>' . $label . ': </b>';
											
											// Se for textarea, faz mais quebras de linha por questões de beleza.		
											if ( $key_obj['type'] == 'textarea')
												echo '<br/>';
												
											echo $valor_final;
	
											echo '<br/><br/>';
										}
										
									}
									
									$i += 1;
									
								}
								
								echo '</p>';
								
							}
*/
							
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