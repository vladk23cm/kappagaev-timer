<?php
/**
* Plugin Name: Kappagave Timer
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Vladk23cm
* Author URI: http://yourwebsiteurl.com/
**/

function timer_shortcode( $atts ){
	$time =  $atts['time'];
	$source = '<div class="kappagev-timer kappagev-timer__mini" time="'. $time .'">

			  
			    <span class="days"></span>
			    <span class="hours"></span>
			    <span class="minutes"></span>
			    <span class="seconds"></span>
			  
			</div>';
 	return $source;
}
add_shortcode('timer', 'timer_shortcode');


add_action( 'wp_enqueue_scripts', 'kappagev_timer_scripts' );
// add_action('wp_print_styles', 'theme_name_scripts'); // можно использовать этот хук он более поздний
function kappagev_timer_scripts() {
	wp_enqueue_style( 'timer-style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
	wp_enqueue_script( 'kappagev-timer-script', plugin_dir_url( __FILE__ ) . 'js/main.js', array('jquery'), '1.0.0', true );
}

// Registering timer post type

add_action( 'init', 'register_timer_type' );
function register_timer_type(){
	register_post_type('timer', array(
		'label'  => 'timer',
		'labels' => array(
			'name'               => 'Таймер', // основное название для типа записи
			'singular_name'      => 'Таймер', // название для одной записи этого типа
			'add_new'            => 'Добавить таймер', // для добавления новой записи
			'add_new_item'       => 'Добавление таймера', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование таймера', // для редактирования типа записи
			'new_item'           => 'Новый таймер', // текст новой записи
			'view_item'          => 'Смотреть таймер', // для просмотра записи этого типа.
			'search_items'       => 'Искать таймер', // для поиска по этим типам записи
			'not_found'          => 'Не найден', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найден в корзине', // если не было найдено в корзине
			'parent_item_colon'  => 'Таймер', // для родителей (у древовидных типов)
			'menu_name'          => 'Таймеры', // название меню
		),
		'description'         => 'Таймеры',
		'public'              => true,
		'show_in_rest'        => true, // добавить в REST API. C WP 4.7
		'menu_icon'           => 'dashicons-sos', 
		//'capability_type'   => 'post',
		//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
		//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
		'hierarchical'        => false,
		'supports'            => array('title','custom-fields'), // 'title','editor','author','thumbnail','excerpt','trackbacks','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => array(),
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	) );
}

// фильтр передает переменную $template - путь до файла шаблона.
// Изменяя этот путь мы изменяем файл шаблона.
add_filter('template_include', 'kappagev_timer_template_plugin');
function kappagev_timer_template_plugin( $template ) {
	
	
	# шаблон для страниц произвольного типа "book"
	// предполагается, что файл шаблона book-tpl.php лежит в папке темы
	global $post;
	if( $post->post_type == 'timer' && pathinfo($template)['filename'] != 'single-timer' && is_singular()){
		
		return plugin_dir_path( __FILE__ ) . 'single-timer.php';
	}

	return $template;

}

function kappagev_author_custom_post_types( $query ) {
  if( is_author() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array(
     'timer'
		));
	  return $query;
	}
}
add_filter( 'pre_get_posts', 'kappagev_author_custom_post_types' );