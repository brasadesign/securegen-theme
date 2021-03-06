<?php
/**
 * Securegen functions and definitions.
 *
 */
// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                => _x( 'Equipe', 'Post Type General Name', 'tema-brasa' ),
		'singular_name'       => _x( 'Equipe', 'Post Type Singular Name', 'tema-brasa' ),
		'menu_name'           => __( 'Equipe', 'tema-brasa' ),
		'parent_item_colon'   => __( 'Item parente', 'tema-brasa' ),
		'all_items'           => __( 'Todos membros', 'tema-brasa' ),
		'view_item'           => __( 'Ver membro', 'tema-brasa' ),
		'add_new_item'        => __( 'Adicionar novo membro', 'tema-brasa' ),
		'add_new'             => __( 'Adicionar novo', 'tema-brasa' ),
		'edit_item'           => __( 'Editar item', 'tema-brasa' ),
		'update_item'         => __( 'Atualizar item', 'tema-brasa' ),
		'search_items'        => __( 'Buscar membro', 'tema-brasa' ),
		'not_found'           => __( 'Não encontrado', 'tema-brasa' ),
		'not_found_in_trash'  => __( 'Não encontrado na lixeira', 'tema-brasa' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-groups',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'equipe', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type', 0 );

if (!function_exists('get_field')) {
  function get_field($field) {
  	global $post;
  	return get_post_meta($post->ID, $field, true);
  }
} 
if (!function_exists('the_field')) {
  function the_field($field) {
  	global $post;
  	echo get_field($field);
  }
}
function team_query( $query ) {
    if ( is_post_type_archive('equipe') ) {
        $query->set( 'orderby', 'rand' );
        return;
    }
}
add_action( 'pre_get_posts', 'team_query' ); 

require get_template_directory() . '/inc/class-metabox.php';
$team_metabox = new Odin_Metabox(
	'team_metabox', // Slug/ID do Metabox (obrigatório)
	'Team', // Nome do Metabox  (obrigatório)
	'equipe', // Slug do Post Type, sendo possível enviar apenas um valor ou um array com vários (opcional)
	'normal', // Contexto (opções: normal, advanced, ou side) (opcional)
	'high' // Prioridade (opções: high, core, default ou low) (opcional)
);
$team_metabox->set_fields(
	array(
		array(
			'id'          => 'team_position',
			'label'       => 'Cargo',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_phone',
			'label'       => 'Telefone',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_email',
			'label'       => 'E-mail',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_twitter',
			'label'       => 'Twitter URL',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_linkedin',
			'label'       => 'Linkedin URL',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_github',
			'label'       => 'Github URL',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_wporg',
			'label'       => __('URL da Conta no WordPress.org','tema-brasa'),
			'type'        => 'text',
			'description' => ''
		),
	)
);

// Adiciona link para download do plugin Download Monitor
if ( ! function_exists( 'brasa_download_link' ) ) {
	function brasa_download_link($id, $class, $text) {
		$download = new DLM_Download($id);
		echo sprintf('<a class="%s" href="%s">%s</a>',$class,$download->get_the_download_link(),$text);
	}
}

// Altera a função do footer, originalmente no arquivo inc/template-tags.php

if ( ! function_exists( 'onepress_footer_site_info' ) ) {
    /**
     * Add Copyright and Credit text to footer
     * @since 1.1.3
     */
    function onepress_footer_site_info()
    {
        ?>
        <?php $onepress_footer_text = get_theme_mod( 'onepress_footer_text', esc_html__('Few Rights Reserved', 'onepress') );?>
        <?php $onepress_footer_text_link = get_theme_mod( 'onepress_footer_text_link' );?>
        <?php if ( $onepress_footer_text_link != '' ) echo '<a href="' . esc_html( $onepress_footer_text_link) . '" alt="" target="_blank">'; ?>
        <?php if ( $onepress_footer_text != '' ) echo '<div class="container">' . esc_html( $onepress_footer_text) . '</div>'; ?>
        <?php if ( $onepress_footer_text_link != '' ) echo '</a>'; ?>

        <?php printf(esc_html__('%2$s %1$s', 'onepress'), esc_attr(date('Y')), esc_attr(get_bloginfo())); ?>
        <span class="sep"> &ndash; </span>
        <?php printf(esc_html__('Desenvolvido pela %1$s com %2$s', 'onepress'), '<a class="logo-brasa" href="' . esc_url('http://brasa.art.br', 'onepress') . '">Brasa</a>', '<a class="logo-wp" href="' . esc_url('https://br.wordpress.org', 'onepress') . '"><i class="fa fa-wordpress" aria-hidden="true"></i></a>'); ?>
        <?php
    }
}
add_action( 'onepress_footer_site_info', 'onepress_footer_site_info' );

// Adicionando o filetype PGP

function my_encrypt_types($encrypt_types){
    $encrypt_types['.pgp'] = 'application/pgp-encrypted'; //Adding pgp extension
    return $encrypt_types;
}
add_filter('upload_mimes', 'my_encrypt_types', 1, 1);