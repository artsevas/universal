<?php
// adding advanced features
if ( ! function_exists( 'universal_theme_setup' ) ) :
  function universal_theme_setup() {
    // add title-tag
    add_theme_support( 'title-tag' );

    // add miniatures
    add_theme_support( 'post-thumbnails', array( 'post' ) ); 

    // add custom logo
    add_theme_support( 'custom-logo', [
      'width'       => 163,
      'flex-height' => true,
      'header-text' => 'Universal',
      'unlink-homepage-logo' => false, // WP 5.5
    ] );

    // register menu
      register_nav_menus( [
        'header_menu' => 'Меню в шапке',
        'footer_menu' => 'Меню в подвале'
      ] );
  }
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );
// connect styles and scripts
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style');
  wp_enqueue_style( 'Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );