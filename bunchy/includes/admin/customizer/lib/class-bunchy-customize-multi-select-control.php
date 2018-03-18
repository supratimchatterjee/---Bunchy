<?php
/**
 * WP Customizer custom control to use multi-select HTML field
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
 * Class Bunchy_Customize_Multi_Select_Control
 */
class Bunchy_Customize_Multi_Select_Control extends WP_Customize_Control {

	/**
	 * Type of the control
	 *
	 * @var string
	 */
	public $type = 'multi-select';

	/**
	 * Render control HTML output
	 */
	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}

		?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif;
if ( ! empty( $this->description ) ) : ?>
				<span
					class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<select <?php $this->link(); ?> multiple="multiple" class="g1-customizer-multi-select-control">
				<?php
				foreach ( $this->choices as $value => $label ) {
					echo '<option value="' . esc_attr( $value ) . '"' . selected( in_array( $value, $this->value(), true ), true, false ) . '>' . esc_html( $label ) . '</option>';
				}
				?>
			</select>
		</label>
		<?php
	}
}
