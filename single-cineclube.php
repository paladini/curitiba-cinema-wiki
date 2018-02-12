<?php get_header(); ?>	


<div id="main_cont">

	<div class="container">

		<div id="cont_left">


			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<h1 class="single_title"><?php the_title(); ?> (Cineclube)</h1>
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
						$mantenedora = get_field('mantenedora');
						$organizadores = get_field('organizadores');
						$financiamento = get_field('formas_de_financiamento_das_atividades_do_cineclube');
						
						if ($mantenedora)
							echo 'Mantenedora: <b>'. $mantenedora .'</b>';
						
						if ($organizadores)
							echo ' | Cor: <b>'. pega_taxonomias($organizadores) . '</b>';
						
						if (verifica_se_tem_valor($financiamento))
							echo ' | Financiamento: <b>'. pega_taxonomias($financiamento) .'</b>';
						
						if ($mantenedora || $organizadores || verifica_se_tem_valor($financiamento))
							echo '</br></br>';
						
						// SEGUNDA LINHA
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
						
													
						echo '</p>';												
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