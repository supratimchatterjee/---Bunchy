<?php
/**
 * The template part for Snax item bar.
 *
 * @package Bunchy_Theme
 */

?>
<?php if ( bunchy_snax_show_item_bar() ) : ?>
<div class="snax-bar snax-bar-item">
		<span class="g1-arrow"><span><?php esc_html_e( 'List item', 'bunchy' ); ?></span></span>

	<div class="snax-bar-details">
		<div class="snax-bar-details-top">
	        <?php
	        $snax_list_id = wp_get_post_parent_id( $post->ID );
	        ?>
	        <?php
	        echo wp_kses_post( sprintf(
		        __( 'Submitted to <a href="%s">"%s"</a>', 'bunchy' ),
		        esc_url( get_the_permalink( $snax_list_id ) ),
		        esc_html( get_the_title( $snax_list_id ) )
	        ) );
	        ?>
		</div>

		<div class="snax-bar-details-bottom">
	        <?php if ( 'publish' === get_post_status() ) : ?>
		        <span class="snax-status-approved"><?php esc_html_e( 'Approved', 'bunchy' ); ?></span>
	        <?php else : ?>
		        <span class="snax-status-pending"><?php esc_html_e( 'Pending for review', 'bunchy' ); ?></span>
	        <?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>
