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

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной', 'universal-theme' ),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );
?>
<?php
/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Полезные файлы',
			array( 'description' => 'Файлы для скачивания', 'classname' => 'widget-downloader', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
    $description = $instance['description'];
    $link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
    if ( ! empty( $description ) ) {
			echo '<p>' . $description . '</p>';
		}
    if ( ! empty( $link ) ) {
			echo '<a target="_blanc" class="widget-link" href="' . $link . '" >
			<img class="widget-link-icon" src="' . get_template_directory_uri(). '/assets/images/download.svg">
			Скачать</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Полезные файлы';
    $description = @ $instance['description'] ?: 'Описание';
    $link = @ $instance['link'] ?: 'https://yandex.ru/';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
    <p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>"
       name="<?php echo $this->get_field_name( 'description' ); ?>" 
       type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
    <p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>"
       name="<?php echo $this->get_field_name( 'link' ); ?>" 
       type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
    $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );
?>

<?php
/**
 * Добавление нового виджета Social.
 */
class Social extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		parent::__construct(
			'social_widget', // ID виджета
			'Социальные сети',
			array( 'description' => 'Наши соцсети', 'classname' => 'widget-social', )
		);

		// скрипты/стили виджета
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета social во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$social_title = $instance['title'];
    $social_link_fb = $instance['social_link_fb'];
		$social_link_tw = $instance['social_link_tw'];
		$social_link_yt = $instance['social_link_yt'];
		$social_link_inst = $instance['social_link_inst'];

		echo $args['before_widget'];
		if ( ! empty( $social_title ) ) {
			echo $args['before_title'] . $social_title . $args['after_title'];
		}
    if ( ! empty( $social_link_fb ) ) {
			echo '<a target="_blanc" class="social-link" href="' . $social_link_fb . '" >
			<img class="social-link-icon" src="' . get_template_directory_uri(). '/assets/images/facebook.svg"></a>';
		}
		if ( ! empty( $social_link_tw ) ) {
			echo '<a target="_blanc" class="social-link" href="' . $social_link_tw . '" >
			<img class="social-link-icon" src="' . get_template_directory_uri(). '/assets/images/twitter.svg"></a>';
		}
		if ( ! empty( $social_link_yt ) ) {
			echo '<a target="_blanc" class="social-link" href="' . $social_link_yt . '" >
			<img class="social-link-icon" src="' . get_template_directory_uri(). '/assets/images/youtube.svg"></a>';
		}
		if ( ! empty( $social_link_inst ) ) {
			echo '<a target="_blanc" class="social-link" href="' . $social_link_inst . '" >
			<img class="social-link-icon" src="' . get_template_directory_uri(). '/assets/images/instagram.svg"></a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета Social
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$social_title = @ $instance['social_title'] ?: 'Наши соцсети';
    $social_link_fb = @ $instance['social_link_fb'] ?: 'https://fb.com/';
		$social_link_tw = @ $instance['social_link_tw'] ?: 'https://twitter.com/';
		$social_link_yt = @ $instance['social_link_yt'] ?: 'https://youtube.com/';
		$social_link_inst = @ $instance['social_link_inst'] ?: 'https://instagram.com/';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'social_title' ); ?>">
			<?php _e( 'Заголовок:' ); ?>
			</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_title' ); ?>" name="<?php echo $this->get_field_name( 'social_title' ); ?>" type="text" value="<?php echo esc_attr( $social_title ); ?>">
		</p>
    <p>
			<label for="<?php echo $this->get_field_id( 'social_link_fb' ); ?>"><?php _e( 'Facebook:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_link_fb' ); ?>"
       name="<?php echo $this->get_field_name( 'social_link_fb' ); ?>" 
       type="text" value="<?php echo esc_attr( $social_link_fb ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'social_link_tw' ); ?>"><?php _e( 'Twitter:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_link_tw' ); ?>"
       name="<?php echo $this->get_field_name( 'social_link_tw' ); ?>" 
       type="text" value="<?php echo esc_attr( $social_link_tw ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'social_link_yt' ); ?>"><?php _e( 'Youtube:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_link_yt' ); ?>"
       name="<?php echo $this->get_field_name( 'social_link_yt' ); ?>" 
       type="text" value="<?php echo esc_attr( $social_link_yt ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'social_link_inst' ); ?>"><?php _e( 'Instagram:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_link_inst' ); ?>"
       name="<?php echo $this->get_field_name( 'social_link_inst' ); ?>" 
       type="text" value="<?php echo esc_attr( $social_link_inst ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['social_title'] = ( ! empty( $new_instance['social_title'] ) ) ? strip_tags( $new_instance['social_title'] ) : '';
    $instance['social_link_fb'] = ( ! empty( $new_instance['social_link_fb'] ) ) ? strip_tags( $new_instance['social_link_fb'] ) : '';
		$instance['social_link_tw'] = ( ! empty( $new_instance['social_link_tw'] ) ) ? strip_tags( $new_instance['social_link_tw'] ) : '';
		$instance['social_link_yt'] = ( ! empty( $new_instance['social_link_yt'] ) ) ? strip_tags( $new_instance['social_link_yt'] ) : '';
		$instance['social_link_inst'] = ( ! empty( $new_instance['social_link_inst'] ) ) ? strip_tags( $new_instance['social_link_inst'] ) : '';

		return $instance;
	}
		// стили виджета
		function add_social_widget_style() {
			// фильтр чтобы можно было отключить стили
			if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
				return;
			?>
			<style type="text/css">
				.my_widget a{ display:inline; }
			</style>
			<?php
		}
	
} 
// конец класса Social_Widget
// регистрация Social_Widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );
?>

<?php
// connect styles and scripts
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style');
  wp_enqueue_style( 'Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
}

add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );

## Изменяем настройки облака тегов
add_filter( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args');
function edit_widget_tag_cloud_args($args) {
	$args['unit'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '13';
	$args['orderby'] = 'count';
	return $args;
}

## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}
?>
