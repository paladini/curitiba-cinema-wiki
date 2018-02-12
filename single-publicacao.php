<?php get_header(); ?>	


<div id="main_cont">

	<div class="container">

		<div id="cont_left">


			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<h1 class="single_title"><?php the_title(); ?> (Publicação)</h1>
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
							$campos_exluidos = [
								'field_5a135b5f14cbc',
								'field_5a135ebef4c16',
								'field_5a13677dc5762',
								'field_5a136b820653d',
								'field_5a136dfb6f559',
								'field_5a137157a4647',
								'field_5a149d2966c92',
								'field_5a14a5b027728',
								'field_5a14b001811a7'
							];
							
							foreach ($campos_exluidos as $c) {
								if ($field['key'] == $c) {
									return False;
								}
							}
							
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
						$autor = get_field('autor_autor');
						$editor = get_field('autor_editor');
						$mantenedora_pf = get_field('mantenedora_pf');
						$mantenedora_pj = get_field('mantenedora_pj');
						$termos_descritivos = get_field('termos_descritivos');
						$lancamento = get_field('data_de_fundacao');
						$defesa = get_field('data_da_defesa_para_pesquisas_academicas');
						$fundacao = get_field('data_de_fundacao');
						$encerramento = get_field('encerramento');
						$cidade_de_origem = get_field('cidade_de_origem');
						$grafica = get_field('grafica');
						$orcamento = get_field('orcamento');
						$tem_valor = False;
						
						if ($autor) {
							$tem_valor = True;
							echo 'Autor: <b>' . pega_taxonomias($autor) . '</b>';
						}
						
						if ($editor) {
							if ($tem_valor)
								echo ' | ';
							
							$tem_valor = True;
							echo 'Editor: <b>' . pega_taxonomias($editor) . '</b>';
						}
						
						if ($mantenedora_pf) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Mantenedora: <b>'. pega_taxonomias($mantenedora_pf);
							if ($mantenedora_pj) {
								echo ', ' . pega_taxonomias($mantenedora_pj);
							}
							echo '</b>';
						} elseif ($mantenedora_pj) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Mantenedora: <b>'. pega_taxonomias($mantenedora_pj) . '</b>';
						}
						
						if ($termos_descritivos) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Termos descritores: <b>'. pega_taxonomias($termos_descritivos) . '</b>';
						}
						
						if ($lancamento) {							
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Lançamento: <b>'. $lancamento . '</b>';
						}
						
						if ($defesa) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Defesa: <b>'. $defesa . '</b>';
						}
						
						if ($fundacao) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Fundação: <b>'. $fundacao . '</b>';
						}
						
						if ($encerramento) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Encerramento: <b>'. $encerramento . '</b>';
						}
						
						if ($cidade_de_origem) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Origem: <b>'. pega_taxonomias($cidade_de_origem) . '</b>';
						}
						
						if ($grafica) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Gráfica: <b>'. pega_taxonomias($grafica) . '</b>';
						}	
						
						if ($orcamento) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Orçamento: <b>'. $orcamento . '</b>';
						}	

						$ficha_catalografica = get_field('ficha_catalografica');
						if ($ficha_catalografica) {
							echo '</br></br>';
							echo '<h2>Ficha Catalográfica</h2>';
							echo $ficha_catalografica;
						}
						
						$banca_de_aprovacao = get_field('orientador_e_banca_academica');
						if ($banca_de_aprovacao) {
							echo '<br/><br/>';
							echo 'Banca de Aprovação: <b>'. pega_taxonomias($banca_de_aprovacao) . '</b>';
						}	
						
						$redacao = get_field('redacao_eou_expediente_do_periodico');
						if ($redacao) {
							echo '<br/><br/>';
							echo 'Redação: <b>'. pega_taxonomias($redacao) . '</b>';
						}	
						
						$colaboradores = get_field('colaboradores');
						if ($colaboradores) {
							echo '<br/><br/>';
							echo 'Colaboradores: <b>'. pega_taxonomias($colaboradores) . '</b>';
						}	
						
						// SEGUNDA LINHA
/*
						$tematica = get_field('tematica');
						$periodicidade = get_field('periodicidade');
						$numero_sessoes = get_field('numero_de_sessoes_ja_realizadas');
						$primeira_sessao = get_field('data_da_primeira_sessao');
						$tem_valor = False;
						
						if ($tematica || $periodicidade || $numero_sessoes || $primeira_sessao)
							echo '</br></br>';
						
						if ($tematica) {
							$tem_valor = True;
							echo 'Temática: <b>' . pega_taxonomias($tematica) . '</b>';
						}
							
							
						if ($periodicidade) {
							if ($tem_valor)
								echo ' | ';
							
							$tem_valor = True;
							echo 'Periodicidade: <b>' . pega_taxonomias($periodicidade) . '</b>';
						}
							
						if ($numero_sessoes) {
							if ($tem_valor)
								echo ' | ';

							$tem_valor = True;
							echo 'Número de Sessões: <b>' . $numero_sessoes . '</b>';
						}
							
							
						if ($data_da_primeira_sessao) {
							if ($tem_valor)
								echo ' | ';

							$tem_valor = True;
							echo 'Primeira Sessão: <b>' . $data_da_primeira_sessao . '</b>';
						}
*/
						
						
						// TERCEIRA LINHA
						$site = get_field('site_oficial_eou_perfis_em_redes_sociais');
						
						if ($site) {
							echo '<br/><br/>';
							echo 'Site: <b><a href="'. $site .'">' . $site . '</a></b>';
						}
							
						if (get_field('sede_do_cineclube_endereco')) {
							if ($site)
								echo ' | ';
							
							echo '<b>Endereço</b><br/>';
							echo get_field('sede_do_cineclube_endereco');
							
							if (get_field('sede_do_cineclube_cidade'))
								echo ' - ' . get_field('sede_do_cineclube_cidade');
								
							if (get_field('sede_do_cineclube_estado_cidade'))
								echo ' (' . get_field('sede_do_cineclube_estado_cidade') . ').';
								
							if (get_field('sede_do_cineclube_cep_codigo_postal'))
								echo ' CEP ' . get_field('sede_do_cineclube_cep_codigo_postal');
							
						}
						
						// Histórico
						$historico = get_field('breve_historico');
						if ($historico) {
							echo '</br></br>';
							echo '<h2>Histórico</h2>';
							echo $historico;
						}
						
						// Galeria
						$imagem1 = get_field('arquivo_de_midia_imagem_1');
						$imagem2 = get_field('arquivo_de_midia_imagem_2');
						$imagem3 = get_field('arquivo_de_midia_imagem_3');
						
						if ($imagem1 || $imagem2 || $imagem3) {
							echo '<br/><br/>';
							echo '<h2 style="text-align: center;">Galeria</h2><br/>';
						}
						
						if ($imagem1) {
							echo '<img src="'. $imagem1["url"] .
								'" height="300" style="text-align: center; margin: 0 auto; display: block; float: none;"/>';
							echo '<br/>';
						}
						if ($imagem2) {
							echo '<img src="'. $imagem2["url"] .
								'" height="300" style="text-align: center; margin: 0 auto; display: block; float: none;"/>';
							echo '<br/>';
						}
						if ($imagem3)
							echo '<img src="'. $imagem3["url"] .
								'" height="300" style="text-align: center; margin: 0 auto; display: block; float: none;"/>';
						
													
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