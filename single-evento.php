<?php get_header(); ?>	


<div id="main_cont">

	<div class="container">

		<div id="cont_left">


			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<h1 class="single_title"><?php the_title(); ?> (Evento)</h1>
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
						
						// Detalhes
						echo '<p style="text-align: justify;">';
						
						$nome_do_evento_ingles = get_field('nome_do_evento_em_ingles_se_houver');
						if ($nome_do_evento_ingles) {
							echo 'Nome do evento em inglês: <b>' . pega_taxonomias($nome_do_evento_ingles) . "</b>";
						}
						
						// Imagem (se houver)
						$imagem1 = get_field('arquivo_de_midia_logomarca');
						if ($imagem1) {
							echo '<br/>';
							echo '<img src="'. $imagem1["url"] .
								'" height="300" style="text-align: center; margin: 0 auto; display: block; float: none;"/>';
							echo '<br/>';
						}
						
						
						
						// PRIMEIRA LINHA
						$tematica = get_field('tematica');
						$tipo_de_evento = get_field('tipo_de_evento');
						$periodicidade = get_field('periodicidade'); 
						$categorias = get_field('categorias_que_o_evento_abrange');
						$site_oficial = get_field('site_oficial_eou_perfis_em_redes_sociais'); 
						$tem_valor = False;
						
						if ($tematica) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Temática: <b>'. pega_taxonomias($tematica) . '</b>';
						}
						
						if ($tipo_de_evento) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Tipo de Evento: <b>'. pega_taxonomias($tipo_de_evento) . '</b>';
						}
						
						if ($periodicidade) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Periodicidade: <b>'. pega_taxonomias($periodicidade) . '</b>';
						}
						
						if ($categorias) {
							if ($tem_valor)
								echo ' | ';
								
							$tem_valor = True;
							echo 'Categorias: <b>'. pega_taxonomias($categorias) . '</b>';
						}
						
						if ($site) {
							if ($tem_valor)
								echo " | ";
							$tem_valor = True;
							echo 'Site: <b><a href="'. $site .'">' . $site . '</a></b>';
						}
							
						echo '<br/><br/>';
						
						// SEGUNDA LINHA
						$fundadores = get_field('fundadores_e_diretores_do_evento');
						if ($fundadores) {
							echo 'Fundadores e Diretores do evento: <b>' . pega_taxonomias($fundadores) . '</b>';
						}
						echo '<br/><br/>';
						
						
						
						
						
						// TERCEIRA LINHA
						$mantenedor_pf = get_field('mantenedor_pf');
						$mantenedor_pj = get_field('mantenedor_pj');
						$data_funadacao = get_field('data_de_fundacao');
						$data_fechamento = get_field('data_de_fechamento_eou_encerramento');
						$publico_estimado = get_field('publico_estimado');
						$tem_valor = False;
						
						if ($mantenedor_pf) {
							$tem_valor = True;
							echo 'Mantenedor: <b>'. pega_taxonomias($mantenedor_pf);
							if ($mantenedor_pj) {
								echo ', ' . pega_taxonomias($mantenedor_pj);
							}
							echo '</b>';
						} elseif ($mantenedor_pj) {	
							$tem_valor = True;
							echo 'Mantenedor: <b>'. pega_taxonomias($mantenedor_pj) . '</b>';
						}
						
						if ($data_funadacao) {
							if ($tem_valor)
								echo " | ";
							$tem_valor = True;
							echo 'Data de Fundação: <b>' . date("d/m/Y", strtotime($data_funadacao)) . '</b>';
						}
						
						if ($data_fechamento) {
							if ($tem_valor)
								echo " | ";
							$tem_valor = True;
							echo 'Data de Encerramento: <b>' . date("d/m/Y", strtotime($data_fechamento)) . '</b>';
						}
						
						if ($publico_estimado) {
							if ($tem_valor)
								echo " | ";
							$tem_valor = True;
							echo 'Publicado Estimado: <b>' . $publico_estimado . ' pessoas</b>';
						}
						echo '<br/><br/>';
						
						
						
						// QUARTA LINHA
						$locais_onde_ocorrem = get_field('locais_onde_ocorrem');
						$tem_valor = False;
						
						if (get_field('sede_ou_espaco_principal_do_evento_endereco')) {
							$tem_valor = True;
							echo '<b>Endereço: </b>';
							echo get_field('sede_ou_espaco_principal_do_evento_endereco');
							
							if (get_field('sede_ou_espaco_principal_do_evento_cidade'))
								echo ' - ' . get_field('sede_ou_espaco_principal_do_evento_cidade');
								
							if (get_field('sede_ou_espaco_principal_do_evento_estado_cidade'))
								echo ' (' . get_field('sede_ou_espaco_principal_do_evento_estado_cidade') . ').';
								
							if (get_field('sede_ou_espaco_principal_do_evento_cep_codigo_postal'))
								echo ' CEP ' . get_field('sede_ou_espaco_principal_do_evento_cep_codigo_postal');
							
						}
						if ($locais_onde_ocorrem) {
							if ($tem_valor)
								echo " | ";
							$tem_valor = True;
							echo 'Locais onde ocorrem as atividades do evento: <b>' . pega_taxonomias($locais_onde_ocorrem) . '</b>';
						}
						echo '<br/><br/>';
						
						
						
						
						// ULTIMA LINHA
						$equipe_tecnica = get_field('equipe_tecnica_preferencia_para_a_ultima_edicao');
						if ($equipe_tecnica) {
							echo 'Equipe Técnica: <b>' . pega_taxonomias($equipe_tecnica) . "</b>";
						}
						
						// Galeria
						$imagem1 = get_field('arquivos_de_midia_fotografias');						
						if ($imagem1) {
							echo '<br/><br/>';
							echo '<h2 style="text-align: center;">Galeria</h2><br/>';
							echo '<img src="'. $imagem1["url"] .
								'" height="300" style="text-align: center; margin: 0 auto; display: block; float: none;"/>';
							echo '<br/>';
						}
						
						// Histórico
						$historico = get_field('breve_historico');
						if ($historico) {
							echo '</br></br>';
							echo '<h2>Histórico</h2>';
							echo $historico;
						}
						
						// Filmes Selecionados
						$selecionados = get_field('programas_filmes_selecionados');
						if ($selecionados) {
							echo '</br></br>';
							echo '<h2>Programas - Filmes Selecionados</h2>';
							echo $selecionados;
						}
						
						// Filmes Selecionados
						$premiados = get_field('filmes_premiados');
						if ($premiados) {
							echo '</br></br>';
							echo '<h2>Filmes Premiados</h2>';
							echo $$premiados;
						}
						
						
						// SEGUNDA LINHA
/*
						$tematica = get_field('tematica');
						$periodicidade = get_field('periodicidade');
						$numero_sessoes = get_field('numero_de_sessoes_ja_realizadas');
						$primeira_sessao = get_field('data_da_primeira_sessao');
						$tem_valor = False;
						
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
						
						if ($site || $sede)
							echo '</br></br>';
*/
/*
						
						// TERCEIRA LINHA
						$site = get_field('site_oficial_eou_perfis_em_redes_sociais');
						
						if ($site)
							echo 'Site: <b><a href="'. $site .'">' . $site . '</a></b>';
							
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
						
						// Itinerância
						$itinerancia = get_field('itinerancia_pergunta');
						echo '</br></br>';
						if ($itinerancia['value'] == 'Sim') {
							echo 'O cineclube era realizado em mais locais? <b>Sim</b>.';
							echo 'Locais: <b>' . pega_taxonomias(get_field('itinerancia_onde')) . '</b>';
						} else {
							echo 'O cineclube era realizado em mais locais? <b>Não</b>.';
						}
						
						// Histórico
						$historico = get_field('historico');
						if ($historico) {
							echo '</br></br>';
							echo '<h2>Histórico</h2>';
							echo $historico;
						}
						
						// Galeria
						$imagem1 = get_field('arquivo_de_midia_fotografia_imagem_1');
						$imagem2 = get_field('arquivo_de_midia_fotografia_imagem_2');
						$imagem3 = get_field('arquivo_de_midia_fotografia_imagem_3');
						
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
						
*/
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
*/
								
								echo '</p>';
								
// 							}
							
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