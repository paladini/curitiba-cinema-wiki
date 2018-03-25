<?php


include('settings.php');

/**
 * Enable ACF 5 early access
 * Requires at least version ACF 4.4.12 to work
 */
define('ACF_EARLY_ACCESS', '5');

if (function_exists('add_theme_support')) {


	add_theme_support('menus');


	register_nav_menu('header-menu','Header Menu');


//	register_nav_menu('footer-menu','Footer Menu');


	add_theme_support( 'post-thumbnails' );


	add_image_size( 'slideshow-image', 980, 350, true);


	add_image_size( 'post-image', 420, 240, true);


	add_image_size( 'may-like-image', 205, 120, true );


	add_image_size('home-featured', 670, 376, true);


	add_image_size('home-featured-right', 297, 147, true);


	add_image_size('home-wide-box', 483, 271, true);


	add_image_size('home-med-box', 319, 186, true);


	add_image_size('home-small-box', 237, 139, true);


}


add_filter( 'pre_get_posts', 'my_get_posts' );

function my_get_posts( $query ) {

	if ( is_home() && $query->is_main_query() )
		$query->set( 'post_type', array( 'post', 'page', 'filme') );

	return $query;
}

function get_category_id($cat_name){


	$term = get_term_by('name', $cat_name, 'category');


	return $term->term_id;


}


function ds_get_excerpt($num_chars) {


    $temp_str = substr(strip_tags(get_the_content()),0,$num_chars);


    $temp_parts = explode(" ",$temp_str);


    $temp_parts[(count($temp_parts) - 1)] = '';


    


    if(strlen(strip_tags(get_the_content())) > 125)


      return implode(" ",$temp_parts) . '...';


    else


      return implode(" ",$temp_parts);


}


if ( function_exists('register_sidebar') ) {


        register_sidebar(array(


                'name'=>'Sidebar',


		'before_widget' => '<div class="side_box">',


		'after_widget' => '</div>',


		'before_title' => '<h3 class="side_title">',


		'after_title' => '</h3>',


	));


        register_sidebar(array(


                'name'=>'Footer',


		'before_widget' => '<div class="footer_box">',


		'after_widget' => '</div>',


		'before_title' => '<h3>',


		'after_title' => '</h3>',


	));	


}


// EX POST CUSTOM FIELD START


$prefix = 'ex_';


$meta_box = array(


    'id' => 'my-meta-box',


    'title' => 'Custom meta box',


    'page' => 'post',


    'context' => 'normal',


    'priority' => 'high',


    'fields' => array(


        array(


            'name' => 'Show in slideshow',


            'id' => $prefix . 'show_in_slideshow',


            'type' => 'checkbox'


        )


    )


);


add_action('admin_menu', 'mytheme_add_box');


// Add meta box


function mytheme_add_box() {


    global $meta_box;


    add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);


}


// Callback function to show fields in meta box


function mytheme_show_box() {


    global $meta_box, $post;


    // Use nonce for verification


    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


    echo '<table class="form-table">';


    foreach ($meta_box['fields'] as $field) {


        // get current post meta data


        $meta = get_post_meta($post->ID, $field['id'], true);


        echo '<tr>',


                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',


                '<td>';


        switch ($field['type']) {


            case 'text':


                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];


                break;


            case 'textarea':


                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];


                break;


            case 'select':


                echo '<select name="', $field['id'], '" id="', $field['id'], '">';


                foreach ($field['options'] as $option) {


                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';


                }


                echo '</select>';


                break;


            case 'radio':


                foreach ($field['options'] as $option) {


                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];


                }


                break;


            case 'checkbox':


                echo '<input type="checkbox" value="Yes" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';


                break;


        }


        echo     '<td>',


            '</tr>';


    }


    echo '</table>';


}


add_action('save_post', 'mytheme_save_data');


// Save data from meta box


function mytheme_save_data($post_id) {


    global $meta_box;


    // verify nonce


    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {


        return $post_id;


    }


    // check autosave


    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {


        return $post_id;


    }


    // check permissions


    if ('page' == $_POST['post_type']) {


        if (!current_user_can('edit_page', $post_id)) {


            return $post_id;


        }


    } elseif (!current_user_can('edit_post', $post_id)) {


        return $post_id;


    }


    foreach ($meta_box['fields'] as $field) {


        $old = get_post_meta($post_id, $field['id'], true);


        $new = $_POST[$field['id']];


        if ($new && $new != $old) {


            update_post_meta($post_id, $field['id'], $new);


        } elseif ('' == $new && $old) {


            delete_post_meta($post_id, $field['id'], $old);


        }


    }


}


// EX POST CUSTOM FIELD END


/* Custom fields for PAGES Starts */


add_action( 'add_meta_boxes', 'pages_extra_fields_box' );


function pages_extra_fields_box() {


    add_meta_box( 


        'pages_extra_fields_box_id',


        __( 'Page Details', 'rochebros' ),


        'pages_extra_fields_box_content',


        'post',


        'normal',


        'high'


    );


}


function pages_extra_fields_box_content( $post ) {


	wp_nonce_field( plugin_basename( __FILE__ ), 'pages_extra_fields_box_content_nonce' ); ?>


<style type="text/css">


.page_extra_tbl input[type=text] { width: 350px; padding: 5px 8px; }


.page_extra_tbl select { min-width: 50px; }


.page_extra_tbl textarea { width: 350px; height: 80px; padding: 5px 8px; }


</style>


	<table border="0" class="pages_extra_tbl">


	<tr>


		<td>Type:</td>


		<td><select name="page_featured_type">


			<option value="">image</option>


			<option value="youtube" <?php if(get_post_meta( $post->ID, 'page_featured_type', true ) == 'youtube') { echo 'selected="selected"'; } ?>>youtube</option>


			<option value="vimeo" <?php if(get_post_meta( $post->ID, 'page_featured_type', true ) == 'vimeo') { echo 'selected="selected"'; } ?>>vimeo</option>


		</select></td>


	</tr>


	<tr>


		<td>Video ID:</td>


		<td><input type="text" name="page_video_id" value="<?php echo get_post_meta( $post->ID, 'page_video_id', true ); ?>" /></td>


	</tr>


	<tr>


		<td colspan="2">ex. <b>h6zo_7nvwNU</b> (youtube)<br />ex. <b>39792837</b> (vimeo)</td>


	</tr>


	</table>


	


<?php


}


add_action( 'save_post', 'pages_extra_fields_box_save' );


function pages_extra_fields_box_save( $post_id ) {


	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 


	return;


	if ( !wp_verify_nonce( $_POST['pages_extra_fields_box_content_nonce'], plugin_basename( __FILE__ ) ) )


	return;


	if ( 'page' == $_POST['post_type'] ) {


		if ( !current_user_can( 'edit_page', $post_id ) )


		return;


	} else {


		if ( !current_user_can( 'edit_post', $post_id ) )


		return;


	}


	$page_featured_type = $_POST['page_featured_type'];


	$page_video_id = $_POST['page_video_id'];


	update_post_meta( $post_id, 'page_featured_type', $page_featured_type );


	update_post_meta( $post_id, 'page_video_id', $page_video_id );


}


/* Custom fields for PAGES Ends */


// **** PRODUCTION - Template1 Search START ****


class template1_search extends WP_Widget {


	function template1_search() {


		parent::WP_Widget(false, 'Custom Search');


	}


	function widget($args, $instance) {


                $args['search_title'] = $instance['search_title'];


		t1_func_search($args);


	}


	function update($new_instance, $old_instance) {


		return $new_instance;


	}


	function form($instance) {


                $search_title = esc_attr($instance['search_title']);


?>


                <p><label for="<?php echo $this->get_field_id('search_title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('search_title'); ?>" name="<?php echo $this->get_field_name('search_title'); ?>" type="text" value="<?php echo $search_title; ?>" /></label></p>


<?php


	}


 }


function t1_func_search($args = array(), $displayComments = TRUE, $interval = '') {


	global $wpdb;


        echo $args['before_widget']; 


        


        if($args['search_title'] != '')


            echo $args['before_title'] . $args['search_title'] . $args['after_title']; ?>


        <div class="t1_search_cont">


            <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">


            <input type="text" name="s" id="s" />


            <!--<INPUT TYPE="image" SRC="<?php bloginfo('stylesheet_directory'); ?>/images/search-icon.jpg" class="t1_search_icon" BORDER="0" ALT="Submit Form">-->


	    <input type="submit" value="SEARCH" />


            </form>


        </div><!--//t1_search_cont-->


        <?php


        echo $args['after_widget'];


        wp_reset_query();


        


}


register_widget('template1_search');  


// **** PRODUCTION - Template1 Search END ****

// **** COMEÇO DAS CUSTOMIZAÇÕES FREDERICO NETO ****


// Remove o metabox do slug/permalink para poder fazer o custom URL
function remove_post_meta_box() {
    remove_meta_box('slugdiv', 'post', 'normal');
}
add_action('admin_menu', 'remove_post_meta_box');


// Filter para modificar informações antes de inserir o post no banco de dados.
/*
function atualiza_post( $data , $postarr ) {
	echo get_field('nome_da_obra_portugues');
	
	$data['post_status'] = 'publish';
	
	if ( get_post_type() == 'filme' || $data["post_type"] == 'filme' ) {
	    echo 'Aqui';
      	$data['post_title'] = get_field('nome_da_obra_portugues');
		$data['post_date'] = get_field('data_de_lancamento');
		//$my_post['rewrite'] = array('slug' => 'filme');
    } elseif ( get_post_type() == 'pessoa_juridica' || $data["post_type"] == 'pessoa_juridica' ) {
		$data['post_title'] = get_field('title');
	} elseif ( get_post_type() == 'pessoa_fisica' || $data["post_type"] == 'pessoa_fisica'  ) {
		$data['post_title'] = get_field('title');
	} elseif ( get_post_type() == 'cineclube' || $data["post_type"] == 'cineclube'  ) {
		$data['post_title'] = get_field('title');
    } elseif ( get_post_type() == 'evento' || $data["post_type"] == 'evento'  ) {
		$data['post_title'] = get_field('title');
    } elseif ( get_post_type() == 'sala_cinema' || $data["post_type"] == 'sala_cinema'  ) {
		$data['post_title'] = get_field('title');
    } elseif ( get_post_type() == 'formacao' || $data["post_type"] == 'formacao'  ) {
		$data['post_title'] = get_field('title');
    } elseif ( get_post_type() == 'marco_legal' || $data["post_type"] == 'marco_legal'  ) {
		$data['post_title'] = get_field('title');
    } elseif ( get_post_type() == 'publicacao' || $data["post_type"] == 'publicacao'  ) {
		$data['post_title'] = get_field('title');
    } else {
	    echo 'Error #1';
    }
    
  	return $data;
}

add_filter( 'wp_insert_post_data', 'atualiza_post', '99', 2 );
*/


// Auto-update o título do post baseado no atributo 'title' (https://support.advancedcustomfields.com/forums/topic/createupdate-post-title-from-acf-fields/)
function my_post_title_updater( $post_id ) {

    $my_post = array();
    $my_post['ID'] = $post_id;
    $my_post['status'] = 'publish';

    if ( get_post_type() == 'filme' ) {
      	$my_post['post_title'] = get_field('nome_da_obra_portugues');
      	
      	// Configurando data de publicação do filme
      	$my_post['post_date'] = date("Y-m-d H:i:s", strtotime(get_field('data_de_lancamento')));
      	
      	// Configurando imagem de destaque
      	set_post_thumbnail($post_id, get_field('fotograma_ou_fotografia_still_01')['id']);
      	
      	// Criando taxonomia: Nomes dos Diretores

/*
      	$nomes_diretores = get_field('nome_dos_diretores');
      	foreach ($nomes_diretores AS $t) {
	      	$object = get_page_by_title( $t->name, $output, $post_type );
	      	
	      	$obj_id = array (
		      	'post_type' => 'pessoa_fisica',
		      	'post_title' => $t->name,
		      	'post_status' => 'publish'
		      	
	      	);
      	}
*/
      	

		//$my_post['post_date'] = get_field('data_de_lancamento');
    } elseif ( get_post_type() == 'pessoa_juridica' ) {
		$my_post['post_title'] = get_field('title');
	} elseif ( get_post_type() == 'pessoa_fisica' ) {
		$my_post['post_title'] = get_field('title');
	} elseif ( get_post_type() == 'cineclube' ) {
		
		// Como o titulo do cineclube é uma taxonomia, processo é um pouco diferente.
		$title = get_field('title');
		$titulo = "";
		foreach ($title as $t) {
			$titulo = $titulo . $t->name . " / ";
		}
		$titulo = substr($titulo, 0, -2);

		// Definindo título, data de publicação e imagem destaque
		$my_post["post_title"] = $titulo;
		$my_post['post_date'] = date("Y-m-d H:i:s", strtotime(get_field('data_da_primeira_sessao')));
		set_post_thumbnail($post_id, get_field('arquivo_de_midia_logomarca')['id']);

    } elseif ( get_post_type() == 'evento' ) {
// 		$my_post['post_title'] = get_field('title');
		
		
		// Como o titulo do cineclube é uma taxonomia, processo é um pouco diferente.
		$title = get_field('title');
		$titulo = "";
		foreach ($title as $t) {
			$titulo = $titulo . $t->name . " / ";
		}
		$titulo = substr($titulo, 0, -2);

		// Definindo título, data de publicação e imagem destaque
		$my_post["post_title"] = $titulo;
		$my_post['post_date'] = date("Y-m-d H:i:s", strtotime(get_field('data_de_fundacao')));
	
    } elseif ( get_post_type() == 'sala_cinema' ) {
	    
		// Como o titulo do cineclube é uma taxonomia, processo é um pouco diferente.
		$title = get_field('title');
		$titulo = "";
		foreach ($title as $t) {
			$titulo = $titulo . $t->name . " / ";
		}
		$titulo = substr($titulo, 0, -2);

		// Definindo título, data de publicação e imagem destaque
		$my_post["post_title"] = $titulo;
		$my_post['post_date'] = date("Y-m-d H:i:s", strtotime(get_field('data_da_primeira_sessao')));
		
    } elseif ( get_post_type() == 'formacao' ) {
// 		$my_post['post_title'] = get_field('title');
		
		// Como o titulo do cineclube é uma taxonomia, processo é um pouco diferente.
		$title = get_field('title');
		$titulo = "";
		foreach ($title as $t) {
			$titulo = $titulo . $t->name . " / ";
		}
		$titulo = substr($titulo, 0, -2);

		// Definindo título, data de publicação e imagem destaque
		$my_post["post_title"] = $titulo;
		$my_post['post_date'] = date("Y-m-d H:i:s", strtotime(get_field('data_de_fundacao')));
		
    } elseif ( get_post_type() == 'marco_legal' ) {
// 		$my_post['post_title'] = get_field('title');
	
		// Como o titulo do cineclube é uma taxonomia, processo é um pouco diferente.
		$title = get_field('title');
		$titulo = "";
		foreach ($title as $t) {
			$titulo = $titulo . $t->name . " / ";
		}
		$titulo = substr($titulo, 0, -2);

		// Definindo título, data de publicação e imagem destaque
		$my_post["post_title"] = $titulo;
		$my_post['post_date'] = date("Y-m-d H:i:s", strtotime(get_field('data_de_publicacao')));
		
    } elseif ( get_post_type() == 'publicacao' ) {
// 		$my_post['post_title'] = get_field('title');

		$title = get_field('title');
		$titulo = "";
		foreach ($title as $t) {
			$titulo = $titulo . $t->name . " / ";
		}
		$titulo = substr($titulo, 0, -2);

		// Definindo título, data de publicação e imagem destaque
		$my_post["post_title"] = $titulo;
		$my_post['post_date'] = date("Y-m-d H:i:s", strtotime(get_field('data_de_fundacao')));
    } else {
	    $my_post['post_title'] = 'Error';
	    echo 'Error #1';
    }

    $my_post['post_name'] = sanitize_title($my_post['post_title']);
	
    // Update the post into the database
    // wp_update_post( $my_post );
    
    $post = wp_update_post( $my_post );
	if (is_wp_error($post)) {
	  echo 'WP ERROR: <pre>'; print_r($wp_error); echo '</pre>'; die;
	}

}
add_action('acf/save_post', 'my_post_title_updater', 20); // Roda após o ACF salvar os dados de $_POST['fields']


// Custom Excerpt function for Advanced Custom Fields
function custom_field_excerpt() {
	global $post;
	$text = '';
	
	// Se for filme pega a sinopse, se não for, retorna o excerpt padrão do Wordpress.
	if ( get_post_type() == 'filme' ) {
		$text = get_field('sinopse');
	} else{
		return ds_get_excerpt('140');
// 		return apply_filters( 'get_the_excerpt', $post->post_excerpt, $post );
	}
	
	 //Replace 'your_field_name'
	if ( '' != $text ) {
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]&gt;', ']]&gt;', $text);
		$excerpt_length = 30; // 20 words
		$excerpt_more = apply_filters('excerpt_more', ' ' . '...');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('the_excerpt', $text);
}

// Libera algumas funções de thumbnail para o post
add_theme_support('post-thumbnails');
add_post_type_support( 'filme', 'thumbnail' ); 


?>