<?php

/**
 * Añadir categoría para los bloques creados.
 */
function agregar_categoria_bloques( $categories ) {
	array_unshift( $categories, array(
		'slug'	=> 'wordpycat',
		'title' => __( 'WordPycat', 'wordpycat' ),
		'icon'  => null,
	) );
	return $categories;
}

add_filter( 'block_categories_all', 'agregar_categoria_bloques', 1, 2 );


/**
 * Registrar todos los bloques de ACF
 */

function registrar_bloques() {
    error_log('Registrando bloques');
    if( function_exists('register_block_type') ){
        register_block_type( WORDPYCAT_PATH . 'blocks/wordpycat-block' );
    }
}

add_action( 'acf/init', 'registrar_bloques' );

/**
 * Registrar scripts de los bloques
 */

function registrar_estilo_bloques() {
    $version = '1.0.0';

    // Añadir aquí los scripts de todos los bloques
    wp_register_style( 'wordpycat-block-style', get_template_directory_uri() . 'blocks/wordpycat-block/estilos.css', array(), $version );

}

add_action( 'acf/init', 'registrar_estilo_bloques' );



/**
 * Registrar scripts de los bloques
 */

 function registrar_scripts_bloques() {
    $version = '1.0.0';

    // Añadir aquí los scripts de todos los bloques
    wp_register_script( 'wordpycat-block-js', get_template_directory_uri() . 'blocks/wordpycat-block/app.js', array( 'acf' ), $version, true );

}

add_action( 'acf/init', 'registrar_scripts_bloques' );



/**
 * Añade ruta para que se guarden los custom fields en la carpeta fields.
 * https://www.advancedcustomfields.com/resources/local-json/#saving-explained
 */
function guardar_custom_fields( $path ) {
    $path = WORDPYCAT_PATH. 'fields';

	return $path;
}

add_filter('acf/settings/save_json', 'guardar_custom_fields' );



/**
 * Customiza el nombre de los archivos que se guardan.
 */

function custom_acf_json_filename( $filename, $post, $load_path ) {
    $filename = str_replace(
        array(
            ' ',
            '_',
        ),
        array(
            '-',
            '-'
        ),
        $post['title']
    );
    $normalized = Normalizer::normalize($filename, Normalizer::NFD);
    $filename = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $normalized);
    $filename = strtolower( $filename ) . '.json';

    return $filename;
}
add_filter( 'acf/json/save_file_name', 'custom_acf_json_filename', 10, 3 );



/**
 * Set path for saving ACF JSON files.
 * https://www.advancedcustomfields.com/resources/local-json/#loading-explained
 */
function cargar_custom_fields( $paths ) {
	
    unset($paths[0]);

    $paths[] = WORDPYCAT_PATH . 'fields';

    return $paths;
}

add_filter( 'acf/settings/load_json', 'cargar_custom_fields' );

