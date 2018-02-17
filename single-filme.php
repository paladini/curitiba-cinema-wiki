<?php get_header(); ?>	


<div id="main_cont">

	<div class="container">

		<div id="cont_left">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<!-- Titulo -->
				<h1 class="single_title"><?php the_title(); ?></h1>
				
				<!-- Informações da Obra -->
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
					
					function pega_campos_do_grupo($id_do_grupo) {
						$acf_fields = acf_get_fields_by_id($id_do_grupo);
						$retorno = array();
						
						foreach ($acf_fields as $field) {
							
							// Pega a label do campo excluindo numeração. E.g: "1.01 - Titulo"
							$label_do_campo = trim(explode('-', $field['label'], 2)[1]);
							$obj_campo = get_field($field['name']);
							$imprimir = verifica_se_tem_valor($field);
							
							if ($field['type'] != "message" && $imprimir) {
								echo '<p style="text-align: justify;"><b>' . $label_do_campo . ': </b>';
							}
								
							
							// De acordo com o tipo do campo, imprime alguma coisa
							if (($field['type'] == 'text' || $field['type'] == 'textarea') && $imprimir) {
// 								print_r($field);
								echo $obj_campo;
							} elseif ($field['type'] == "taxonomy" && $imprimir) {
								
								// Transformando tudo em array
								$temp = array();
								if ( !is_array($obj_campo) )
									array_push($temp, $obj_campo);
								else
									$temp = $obj_campo;
								
								// Verificando se é ID ou Object
								$termo = '';
								foreach ($temp as $t) {
									if ( is_integer($t) ) {
										$termo.= pega_taxonomias(get_term($t, $field['taxonomy'])) . ', ';
									} else {
										if (is_bool($t))
											continue;
										elseif (get_class($t) == 'WP_Term')
											$termo.= pega_taxonomias($t) . ', ';
									}
								}
								$termo = substr($termo, 0, -2);
								echo $termo;
								
								
							} elseif ($field['type'] == "group" && $imprimir) {
								
								$campo1 = $field['name'] . '_' . $field['sub_fields'][0]['name'];
								$campo2 = $field['name'] . '_' . $field['sub_fields'][1]['name'];
									
								if ($field['name'] == 'distribuidor_ou_empresa_distribuidora' ||
									$field['name'] == 'assessoria_de_midias_sociais') {
									$termos = pega_taxonomias(get_field($campo1));
									$termos = $termos . ', ' . pega_taxonomias(get_field($campo2));
									echo $termos;
								} else {
									echo get_field($campo2);
									echo ' (';
									echo pega_taxonomias(get_field($campo1));
									echo ')';
								}
							}
							
							if ($field['type'] != "message" && $imprimir)
								echo '</p>';
							
						}
// 						print_r($acf_fields);
					}
					
					// Trailer da Obra incorporado
					echo '<br/>';
					$trailer_url = get_field("link_do_trailer");
					if ($trailer_url != "")
// 						echo '[arve url="https://youtu.be/Z7g8-GxLTSc" align="center"]';
						echo do_shortcode('[arve url="'. $trailer_url .'" align="center" ]');
					
					// Formato / Periodicidade / Gênero
					$formato = get_field('formato')->name;
					$periodicidade = get_field('periodicidade')->name;
					$genero = get_field('genero');
					$cpb = get_field('numero_do_cpb_certificado_de_produto_brasileiro')->name;
					
					if ($formato != ''|| $periodicidade != '' || $genero != '' || $cpb != '') {
						echo '<h3 style="text-align: center;">Formato</h3>';
						echo '<p style="text-align: center;">';
						
						if ($periodicidade != '')
							echo 'Periodicidade: <b><a href="'. get_term_link(get_field('periodicidade')) .'">' . $periodicidade .'</a></b>';
						
						if ($formato != '')
							echo ' | Formato: <b><a href="'. get_term_link(get_field('formato')) .'">' . $formato . '</a></b>';
						
						if ($genero)
							echo ' | Gênero: <b>'. pega_taxonomias($genero) .'</b>';
							
						if ($cpb != '')
							echo ' | CPB: <b><a href="'. get_term_link(get_field('numero_do_cpb_certificado_de_produto_brasileiro')) .'">' . $cpb . '</a></b>';
							
						echo '</p>';
					}
					
					// Detalhes técnicos
					echo '<h3 style="text-align: center;">Dados Técnicos</h3>';
					echo '<p style="text-align: justify;">';
					$data_lancamento = get_field('data_de_lancamento');
					
					if (get_field('minutagem_minutos'))
						echo 'Minutagem: <b><a href="'. get_term_link(get_field('minutagem_minutos')) .'">'. get_field('minutagem_minutos')->name .' minutos</a></b>';
	
					echo ' | Data de Lançamento: <b>'. date("d/m/Y", strtotime($data_lancamento)) . '</b>';
					
					if (get_field('cor'))
						echo ' | Cor: <b><a href="'. get_term_link(get_field('cor')) .'">'. get_field('cor')->name .'</a></b>';
					
					if (get_field('padrao_de_imagem'))
						echo ' | Padrão de Imagem: <b><a href="'. get_term_link(get_field('padrao_de_imagem')) .'">'. get_field('padrao_de_imagem')->name .'</a></b>';
					
					if (get_field('quadros_por_segundo'))
						echo ' | Quadros por segundo: <b><a href="'. get_term_link(get_field('quadros_por_segundo')) .'">'. get_field('quadros_por_segundo')->name .'</a></b>';
						
					if (get_field('som'))
						echo ' | Som: <b><a href="'. get_term_link(get_field('som')) .'">'. get_field('som')->name .'</a></b>';
					
					if (get_field('janela_de_exibicao'))
						echo ' | Janela: <b><a href="'. get_term_link(get_field('janela_de_exibicao')) .'">'. get_field('janela_de_exibicao')->name .'</a></b>';
					
					if (get_field('bitola_final_ou_principal_de_exibicao'))
						echo ' | Bitola: <b><a href="'. get_term_link(get_field('bitola_final_ou_principal_de_exibicao')) .'">'. get_field('bitola_final_ou_principal_de_exibicao')->name .'</a></b>';				
					echo '</br>';
					echo '</p>';
						
						
						
					// Sinopse
					$sinopse = get_field('sinopse');
					if ($sinopse) {
						echo '<h2 style="text-align: center;">Sinopse</h2>';
						echo '<p style="text-align: justify;">'. $sinopse .'</p>';
					}
					
					
					
					// Termos descritores
					$termos_descritores = pega_taxonomias(get_field('termos_descritores'));
					$nome_dos_diretores = get_field('nome_dos_diretores');
					$nome_da_empresa_produtora_pf = get_field('nome_da_empresa_produtora_pf');
					$nome_da_empresa_produtora_pj = get_field('nome_da_empresa_produtora_pj');
					$nome_da_empresa_distribuidora = get_field('empresa_distribuidora');
					
					if ( $termos_descritores != '')
						echo '<p style="text-align: justify;"><b>Termos descritores: </b>'. $termos_descritores .'</p>';
					
					// Direção
					if ($nome_dos_diretores)
						echo '<p style="text-align: justify;"><b>Direção: </b>'. 
							pega_taxonomias($nome_dos_diretores) .'</p>';
					
					// Empresa Produtora
					if ($nome_da_empresa_produtora_pf && (!is_wp_error($nome_da_empresa_produtora_pf))) {
						echo '<p style="text-align: justify;"><b>Empresa Produtora: </b>'. pega_taxonomias($nome_da_empresa_produtora_pf);
						if ($nome_da_empresa_produtora_pj && (!is_wp_error($nome_da_empresa_produtora_pj))) {
							echo ', ' . pega_taxonomias($nome_da_empresa_produtora_pj);
						}
						echo '</p>';
					} elseif ($nome_da_empresa_produtora_pj && (!is_wp_error($nome_da_empresa_produtora_pj))) {
						echo '<p style="text-align: justify;"><b>Empresa Produtora: </b>'. pega_taxonomias($nome_da_empresa_produtora_pj) . '</p>';
					}
// 					if ($nome_da_empresa_produtora)
// 						echo '<p style="text-align: justify;"><b>Empresa Produtora: </b>'. 
// 							pega_taxonomias($nome_da_empresa_produtora) .'</p>';
							
					// Empresa Distribuidora
					if ($nome_da_empresa_distribuidora)
						echo '<p style="text-align: justify;"><b>Empresa Distribuidora: </b>'. 
							pega_taxonomias($nome_da_empresa_distribuidora) .'</p>';
					
					// Site URL
					$site_url = get_field('site_da_obra');
					if ($site_url) {
						echo '<p style="text-align: justify;"><b>Site: </b><a href="'. $site_url 
							.'" target="_blank" follow="nofollow">' . $site_url .'"</a></p>';
					}
					
					// Datas
					echo '<p style="text-align: justify;">';
					$data_inicio = get_field('data_de_inicio_da_producao');
					$data_fim = get_field('data_de_encerramento_da_producao');
					
/*
					if ($data_lancamento != "")
						echo '<b>Data de Lançamento: </b>' . date("d/m/Y", strtotime($data_lancamento)); //explode(' ',$data_lancamento)[0];
*/
					
					if ($data_inicio != "")
						echo '<b>Data de início da produção: </b>' . $data_inicio;
					
					if ($data_fim != "")
						echo '<br/><b>Data de encerramento da produção: </b>' . $data_fim;
						
					echo '</p>';	
	
					
					// Redes Sociais
					$facebook = get_field('midias_sociais_facebook');
					$social1 = get_field('midias_sociais_midia1');
					$social2 = get_field('midias_sociais_midia2');
					$social3 = get_field('midias_sociais_midia3');
					$social4 = get_field('midias_sociais_midia4');
					
					if ($facebook != "" || $social1 != "" || $social2 != '' || $social3 != '' || $social4 != '')
						echo '<p style="text-align: justify;"><b>Conexões: </b>';
					
					if ($facebook != "")
						echo '<br/><a href="'. $facebook .'" target="_blank" follow="nofollow">'
								. $facebook . '</a>';
					
					if ($social1 != "")
						echo '<br/><a href="'. $social1 .'" target="_blank" follow="nofollow">'
								. $social1 . '</a>';
					
					if ($social2 != "")
						echo '<br/><a href="'. $social2 .'" target="_blank" follow="nofollow">'
								. $social2 . '</a>';
								
					if ($social3 != "")
						echo '<br/><a href="'. $social3 .'" target="_blank" follow="nofollow">'
								. $social3 . '</a>';
					
					if ($social4 != "")
						echo '<br/><a href="'. $social4 .'" target="_blank" follow="nofollow">'
								. $social4 . '</a>';
								
								
					// Galeria
					$imagem1 = get_field('fotograma_ou_fotografia_still_01');
					$imagem2 = get_field('fotograma_ou_fotografia_still_02');
					$imagem3 = get_field('fotograma_ou_fotografia_still_03');
					
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
 
/*
					$imagem_ids = "";
					if ($imagem1)
						$imagem_ids .= $imagem1['ID'] . ",";
						echo '<img src="'. $imagem1["url"] .'"/>';
					if ($imagem2)
						$imagem_ids .= $imagem2['ID'] . ",";
					if ($imagem3)
						$imagem_ids .= $imagem3['ID'];
					if ($imagem_ids != "")
						echo do_shortcode('[gallery columns="1" size="medium" type="slideshow" ids="'. 
								$imagem_ids .'"]');
*/
					
					
					// Making of
					$making_of = get_field('link_do_making_of');
					$acesso_publico = get_field('link_de_acesso_online_publico_para_a_obra');
					if ($making_of || $acesso_publico)
						echo '<br/>';
					
					if ($making_of)
						echo '<p style="text-align: center;">Link do Making Of: <a href="'. $making_of .'">'. $making_of . '</a></p>';
						
					if ($acesso_publico)
						echo '<p style="text-align: center;">Link do Making Of: <a href="'. $acesso_publico .'">'. $acesso_publico . '</a></p>';
					
					// Equipe Técnica
					echo '<br/>';
					echo '<h2 style="text-align: center;">Equipe Técnica</h2><br/>';
					
					// 4. Elenco e equipe técnica
					pega_campos_do_grupo(503);
					
					// 4. Elenco e equipe técnica – Depto. de Roteiro
					pega_campos_do_grupo(566);
					
					// 4. Elenco e equipe técnica – Depto. de Produção
					pega_campos_do_grupo(593);
					
					// 4. Elenco e equipe técnica – Depto. de Fotografia
					pega_campos_do_grupo(630);
					
					// 4. Elenco e equipe técnica – Depto. de Montagem
					pega_campos_do_grupo(658);
					
					// 4. Elenco e equipe técnica – Depto. de Som
					pega_campos_do_grupo(674);
					
					// 4. Elenco e equipe técnica – Depto. de Trilha Musical
					pega_campos_do_grupo(716);
					
					// 4. Elenco e equipe técnica – Depto. de Arte
					pega_campos_do_grupo(754);
					
					// 4. Elenco e equipe técnica – Depto. de Pós-Produção
					pega_campos_do_grupo(855);
					
					// 4. Elenco e equipe técnica – Depto. de Pós-Produção. Já é exibido manualmente.
// 					pega_campos_do_grupo(872);
					
/*
					echo '<p style="text-align: justify;"><b>Direção: </b>'. pega_taxonomias(get_field('elenco_diretores')) .'</p>';
					echo '<p style="text-align: justify;"><b>Roteiro: </b>'. pega_taxonomias(get_field('roteirista')) .'</p>';
					echo '<p style="text-align: justify;"><b>Produção: </b>'. pega_taxonomias(get_field('produtor')) .'</p>';
					echo '<p style="text-align: justify;"><b>Direção de Fotografia: </b>'. pega_taxonomias(get_field('diretor_de_fotografia')) .'</p>';
					echo '<p style="text-align: justify;"><b>Direção de Arte: </b>'. pega_taxonomias(get_field('direcao_de_arte')) .'</p>';
					echo '<p style="text-align: justify;"><b>Trilha Sonora: </b>'. pega_taxonomias(get_field('direcao_musical')) .'</p>';
					echo '<p style="text-align: justify;"><b>Montagem: </b>'. pega_taxonomias(get_field('montador')) .'</p>';
					echo '<p style="text-align: justify;"><b>Som: </b>'. pega_taxonomias(get_field('diretor_ou_desenhista_de_som_sound_designer')) .'</p>';
*/
					$coordenador_de_ti = get_field('coordenador_de_ti');
					$assessor_de_ti = get_field('assessor_de_ti');
					$programador = get_field('programador');
					$agradecimentos_especiais = get_field('agradecimentos_especiais');
					$agradecimentos = get_field('agradecimentos');
					$colabs = get_field('colaboradores_de_financiamento_coletivo_crowdfunding');
					
					if ($coordenador_de_ti)
						echo '<p style="text-align: justify;"><b>Coordenador de TI: </b>'. 
							pega_taxonomias($coordenador_de_ti) .'</p>';
							
					if ($assessor_de_ti)
						echo '<p style="text-align: justify;"><b>Assessor de TI: </b>'. 
							pega_taxonomias($assessor_de_ti) .'</p>';
							
					if ($programador)
						echo '<p style="text-align: justify;"><b>Programador: </b>'. 
							pega_taxonomias($programador) .'</p>';
							
					if ($agradecimentos_especiais)
						echo '<p style="text-align: justify;"><b>Agradecimentos especiais: </b>'. 
							pega_taxonomias($agradecimentos_especiais) .'</p>';
						
					if ($agradecimentos)
						echo '<p style="text-align: justify;"><b>Agradecimentos: </b>'. pega_taxonomias($agradecimentos) .'</p>';
						
					if ($colabs)
						echo '<p style="text-align: justify;"><b>Colaboradores de financiamento coletivo: </b>'. 
							pega_taxonomias($colabs) .'</p>';
					
					// Arquivo
					echo '<p style="text-align: justify;">';
					$imagem_de_arquivo = get_field('a_obra_possui_imagem_de_arquivo')->name;
					if ($imagem_de_arquivo->name != '')
						echo '<b>A obra possui imagem de arquivo? </b>'. $imagem_de_arquivo->name;
						
					$financiamento = get_field('financiamento_esquema_de_financiamento_a_obra_audiovisual');
					if ($financiamento) {
						echo '<b>Financiamento:</b>';
						foreach ($financiamento as $f) {
							echo '<br/>' . $f->name;
						}
					}
					
					$descricao_arquivo = get_field('descreva_as_imagens_de_arquivo');
					if ($descricao_arquivo != '')
						echo '<b>Descrição dos arquivos: </b>'. $descricao_arquivo;
						
					echo '</p>';
					
					
					
					// Elenco Principal
					$elenco = get_field('personagens_sociais_principais');
					if ($elenco != "") {
						echo '<p style="text-align: justify;"><b>Elenco Principal: </b>';
						echo '<ul>';
						$elenco = explode(';', $elenco);
						foreach ($elenco as $c) {
							echo '<li>'. trim($c) .'</li>';
						}
						echo '</ul></p>';
					}
					
					// Seleções
					$selecoes = get_field('selecoes_em_festivais_e_mostras_em_que_a_obra_audiovisual_participou');
					if ($selecoes != "") {
						echo '<p style="text-align: justify;"><b>Seleções: </b>';
						echo '<ul>';
						$selecoes = explode(';', $selecoes);
						foreach ($selecoes as $c) {
							echo '<li>'. trim($c) .'</li>';
						}
						echo '</ul></p>';
					}
					
					// Críticas
					$criticas = get_field('criticas_eou_materias_jornalisticas_sobre_a_obra_audiovisual');
					if ($criticas != "") {
						echo '<p style="text-align: justify;"><b>Críticas: </b>';
						echo '<ul>';
						$criticas = explode(';', $criticas);
						foreach ($criticas as $c) {
							echo '<li><a href="'. trim($c) .'" target="_blank" follow="nofollow">'
								. trim($c) .'</a></li>';
						}
						echo '</ul></p>';
					}
					
					
					
					// 
					
				?>
				
				<div class="single_inside_content">
					<?php the_content(); ?>
				</div><!--//single_inside_content-->

				<br /><br />
	
				<?php wp_reset_query(); ?>   	


				<div class="clear"></div>

			<?php endwhile; else: ?>

				<h3>Desculpe, conteúdo não encontrado.</h3>

			<?php endif; ?>                    												


		</div><!--//cont_left-->

		<?php get_sidebar(); ?>
		<div class="clear"></div>


	</div><!--//container-->

</div><!--//main_cont-->


<?php get_footer(); ?> 