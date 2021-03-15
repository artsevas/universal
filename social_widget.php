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