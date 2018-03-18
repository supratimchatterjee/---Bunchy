<?php
/**
 * Sticky Start Point Widget
 *
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 * @package Bunchy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}


/**
 * Class Bunchy_Widget_Sticky_Start_Point
 */
class Bunchy_Widget_Sticky_Start_Point extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bunchy_sticky_start_point_widget',                     // Base ID.
			esc_html__( 'Bunchy Sticky Start Point', 'bunchy' ),    // Name
			array(                                                  // Args.
				'description' => esc_html__( 'Use this widget to define place where sticky elements starts', 'bunchy' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, array( 'offset' => 0 ) );

		echo '<div class="g1-sticky-sidebar" data-g1-offset="' . esc_attr( $instance['offset'] ) . '">';
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( $instance, array( 'offset' => 0 ) );

		?>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Offset', 'bunchy' ); ?>
				:</label>
			<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"
			       value="<?php echo esc_attr( $instance['offset'] ) ?>"/>
			<small><?php esc_html_e( 'If you have some sticky elements on your site (eg. menu), they can overlap on sticky sidebar. Set offset here to move the sidebar down.', 'bunchy' ); ?></small>
		</p>
		<br/>
		<?php esc_html_e( 'All subsequent widgets will be sticky', 'bunchy' ); ?>
		<br/>
		<br/>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array(
			'offset' => ! empty( $new_instance['offset'] ) ? strip_tags( $new_instance['offset'] ) : 0,
		);

		return $instance;
	}
}
