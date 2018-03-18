<?php
/**
 * The template part for Snax post bar.
 *
 * @package Bunchy_Theme
 */

?>
<?php if ( bunchy_snax_show_post_bar() ) : ?>
<div class="snax-bar snax-bar-post">
	<?php if ( is_single() ) : ?>
	<div class="g1-arrow"><span><?php esc_html_e( 'Open list', 'bunchy' ); ?></span></div>
	<?php else : ?>
	<a class="g1-arrow" href="<?php the_permalink(); ?>"><span><?php esc_html_e( 'Open list', 'bunchy' ); ?></span></a>
	<?php endif; ?>

	<div class="snax-bar-details">
		<div class="snax-bar-details-top">
		<?php
		$snax_item_count = (int) snax_get_post_submission_count();
		$g1_class        = array(
			'snax-li-count',
		);

	if ( 0 === $snax_item_count ) {
		$g1_class[] = 'snax-li-count-0';
	} else if ( 1 === $snax_item_count ) {
		$g1_class[] = 'snax-li-count-1';
	} else {
		$g1_class[] = 'snax-li-count-x';
	}
		?>
		<span class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $g1_class ) ); ?>">
			<?php printf(
				wp_kses_post( _n( '<strong>%d</strong> submission already', '<strong>%d</strong> submissions already', (int) snax_get_post_submission_count(), 'bunchy' ) ),
				(int) snax_get_post_submission_count()
			);
			?>
		</span>
	</div>

		<div class="snax-bar-details-bottom">
			<?php $snax_list_submission_end_date = snax_get_post_submission_end_date(); ?>
			<?php if ( ! empty( $snax_list_submission_end_date ) ) : ?>
				<span class="snax-time-left">
					<span class="snax-date-wrapper"><?php esc_html_e( 'End date:', 'bunchy' ); ?> <span
	                            class="snax-date"><?php echo esc_html( snax_get_post_submission_end_date() ); ?></span></span>
					<span class="snax-time-wrapper"><?php esc_html_e( 'Ends in', 'bunchy' ); ?>
						<span class="snax-time"></span></span>
					</span>
			<?php endif; ?>

			<?php // @csstodo Add plus icons via CSS. ?>
			<?php // @todo Refactor. ?>
			<?php if ( snax_is_post_open_list() && snax_is_post_open_for_submission() ) : ?>
				<?php if ( $snax_item_count ) : ?>
					<a href="<?php echo esc_url( get_the_permalink() . '#snax-new-item-wrapper-' . get_the_ID() ); ?>"><?php esc_html_e( '+ Add yours', 'bunchy' ); ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url( get_the_permalink() . '#snax-new-item-wrapper-' . get_the_ID() ); ?>"><?php esc_html_e( '+ Add first item', 'bunchy' ); ?></a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>
