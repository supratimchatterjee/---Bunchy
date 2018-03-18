<?php
/**
 * Class to display posts in a sidebar
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

if ( ! class_exists( 'Bunchy_Widget_Posts' ) ) :

	/**
	 * Class Bunchy_Widget_Posts
	 */
	class Bunchy_Widget_Posts extends WP_Widget {

		/**
		 * The total number of displayed widgets
		 *
		 * @var int
		 */
		static $counter = 0;

		/**
		 * Bunchy_Widget_Posts constructor.
		 */
		public function __construct() {
			parent::__construct(
				'bunchy_widget_posts',                          // Base ID.
				esc_html__( 'Bunchy Posts', 'bunchy' ),         // Name.
				array(                                          // Args.
					'description' => esc_html__( 'A list of trending posts.', 'bunchy' ),
				)
			);

			self::$counter ++;
		}

		/**
		 * Render widget
		 *
		 * @param array $args Arguments.
		 * @param array $instance Instance of widget.
		 */
		public function widget( $args, $instance ) {
			$instance = wp_parse_args( $instance, $this->get_default_args() );

			$title = apply_filters( 'widget_title', $instance['title'] );

			// Translate title.
			if ( function_exists( 'icl_translate' ) ) {
				$title = icl_translate( 'Bunchy Posts', 'title', $title );
			}

			// HTML id.
			if ( empty( $instance['id'] ) ) {
				$instance['id'] = 'g1-widget-posts-' . self::$counter;
			}

			// HTML class.
			$classes   = explode( ' ', $instance['class'] );
			$classes[] = 'g1-widget-posts';

			$collection_class = array(
				'g1-collection',
			);

			if ( 'numbered' === $instance['template'] ) {
				$collection_class[] = 'g1-collection-numbered';
			}

			echo wp_kses_post( $args['before_widget'] );

			if ( ! empty( $title ) ) {
				echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
			}

			$query = new WP_Query( $this->get_query_args( $instance ) );
			?>
			<div id="<?php echo esc_attr( $instance['id'] ); ?>"
			     class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $classes ) ); ?>">
				<?php if ( $query->have_posts() ) : ?>

					<?php
					$bunchy_settings = apply_filters( 'bunchy_widget_posts_entry_settings', array(
						'elements' => array(
							'featured_media' => $instance['entry_featured_media'],
							'categories'     => $instance['entry_categories'],
							'summary'        => $instance['entry_summary'],
							'author'         => $instance['entry_author'],
							'avatar'         => $instance['entry_avatar'],
							'date'           => $instance['entry_date'],
							'shares'         => $instance['entry_shares'],
							'views'          => $instance['entry_views'],
							'comments_link'  => $instance['entry_comments_link'],
						),
					) );

					$bunchy_template_part = 'standard' === $instance['template'] ? 'template-parts/content-grid-standard' : 'template-parts/content-grid-fancy';

					bunchy_set_template_part_data( $bunchy_settings );
					?>

					<div class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $collection_class ) ); ?>">
						<div class="g1-collection-viewport">
							<ul class="g1-collection-items">
								<?php while ( $query->have_posts() ) : $query->the_post(); ?>

									<li class="g1-collection-item">
										<?php get_template_part( $bunchy_template_part ); ?>
									</li>

								<?php endwhile; ?>
							</ul>
						</div>
					</div>

					<?php bunchy_reset_template_part_data(); ?>
					<?php wp_reset_postdata(); ?>

				<?php else : ?>
					<p>
						<?php esc_html_e( 'Sorry. No data so far.', 'bunchy' ); ?>
					</p>
				<?php endif; ?>
			</div>
			<?php

			echo wp_kses_post( $args['after_widget'] );
		}

		/**
		 * Get category choices
		 *
		 * @return array
		 */
		public function get_category_choices() {
			$choices    = array();
			$categories = get_categories( 'hide_empty=0' );

			foreach ( $categories as $category_obj ) {
				$choices[ $category_obj->slug ] = $category_obj->name;
			}

			return $choices;
		}

		/**
		 * Get tag choices
		 *
		 * @return array
		 */
		public function get_tag_choices() {
			$choices = array();
			$tags    = get_tags( 'hide_empty=0' );

			foreach ( $tags as $tag_obj ) {
				$choices[ $tag_obj->slug ] = $tag_obj->name;
			}

			return $choices;
		}

		/**
		 * Render form
		 *
		 * @param array $instance Instance of widget.
		 *
		 * @return void
		 */
		public function form( $instance ) {
			$instance = wp_parse_args( $instance, $this->get_default_args() );

			if ( function_exists( 'icl_register_string' ) ) {
				icl_register_string( 'Bunchy Posts', 'title', $instance['title'] );
			}

			?>
			<div class="g1-widget-posts">
				<p>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget title', 'bunchy' ); ?>
						:</label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
					       value="<?php echo esc_attr( $instance['title'] ); ?>">
				</p>

				<p>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'max' ) ); ?>"><?php esc_html_e( 'The max. number of entries to show', 'bunchy' ); ?>
						:</label>
					<input size="5" type="text" name="<?php echo esc_attr( $this->get_field_name( 'max' ) ); ?>"
					       id="<?php echo esc_attr( $this->get_field_id( 'max' ) ); ?>"
					       value="<?php echo esc_attr( $instance['max'] ) ?>"/>
				</p>

				<p>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>"><?php esc_html_e( 'Template', 'bunchy' ); ?>
						:</label>
					<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'template' ) ); ?>"
					        id="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>">
						<option
							value="standard"<?php selected( 'standard', $instance['template'] ); ?>><?php esc_html_e( 'standard', 'bunchy' ); ?></option>
						<option
							value="numbered"<?php selected( 'numbered', $instance['template'] ); ?>><?php esc_html_e( 'numbered', 'bunchy' ); ?></option>
					</select>
				</p>


				<p>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>"><?php esc_html_e( 'Sort by', 'bunchy' ); ?>
						:</label>
					<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'sort_by' ) ); ?>"
					        id="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>">
						<option
							value="date"<?php selected( 'date', $instance['sort_by'] ); ?>><?php esc_html_e( 'publish date', 'bunchy' ); ?></option>
						<option
							value="comments"<?php selected( 'comments', $instance['sort_by'] ); ?>><?php esc_html_e( 'comments', 'bunchy' ); ?></option>
						<option
							value="views"<?php selected( 'views', $instance['sort_by'] ); ?>><?php esc_html_e( 'views', 'bunchy' ); ?></option>
						<option
							value="shares"<?php selected( 'shares', $instance['sort_by'] ); ?>><?php esc_html_e( 'shares', 'bunchy' ); ?></option>
					</select>
				</p>

				<p>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'time_range' ) ); ?>"><?php esc_html_e( 'Time range', 'bunchy' ); ?>
						:</label>
					<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'time_range' ) ); ?>"
					        id="<?php echo esc_attr( $this->get_field_id( 'time_range' ) ); ?>">
						<option
							value="day"<?php selected( 'day', $instance['time_range'] ); ?>><?php esc_html_e( 'last 24 hours', 'bunchy' ); ?></option>
						<option
							value="week"<?php selected( 'week', $instance['time_range'] ); ?>><?php esc_html_e( 'last 7 days', 'bunchy' ); ?></option>
						<option
							value="month"<?php selected( 'month', $instance['time_range'] ); ?>><?php esc_html_e( 'last 30 days', 'bunchy' ); ?></option>
						<option
							value="all"<?php selected( 'all', $instance['time_range'] ); ?>><?php esc_html_e( 'all time', 'bunchy' ); ?></option>
					</select>
				</p>

				<?php
				$bunchy_categories          = $this->get_category_choices();
				$bunchy_selected_categories = is_array( $instance['category_slugs'] ) ? $instance['category_slugs'] : array();

				?>
				<p>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'category_slugs' ) ); ?>"><?php esc_html_e( 'Categories (optional)', 'bunchy' ); ?>
						:</label>
					<select multiple="multiple" class="widefat"
					        name="<?php echo esc_attr( $this->get_field_name( 'category_slugs' ) ); ?>[]"
					        id="<?php echo esc_attr( $this->get_field_id( 'category_slugs' ) ); ?>">
						<option value="" <?php selected( in_array( '', $bunchy_selected_categories, true ) ); ?>><?php esc_html_e( '- None -', 'bunchy' ); ?></option>
						<?php foreach ( $bunchy_categories as $bunchy_cat_slug => $bunchy_cat_name ) : ?>
							<option
								value="<?php echo esc_attr( $bunchy_cat_slug ); ?>"
								<?php selected( in_array( $bunchy_cat_slug, $bunchy_selected_categories, true ) ); ?>>
								<?php echo esc_html( $bunchy_cat_name ); ?></option>
						<?php endforeach; ?>
					</select>
				</p>

				<?php
				$bunchy_tags          = $this->get_tag_choices();
				$bunchy_selected_tags = is_array( $instance['tag_slugs'] ) ? $instance['tag_slugs'] : array();

				?>
				<p>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'tag_slugs' ) ); ?>"><?php esc_html_e( 'Tags (optional)', 'bunchy' ); ?>
						:</label>
					<select multiple="multiple" class="widefat"
					        name="<?php echo esc_attr( $this->get_field_name( 'tag_slugs' ) ); ?>[]"
					        id="<?php echo esc_attr( $this->get_field_id( 'tag_slugs' ) ); ?>">
						<option value="" <?php selected( in_array( '', $bunchy_selected_tags, true ) ); ?>><?php esc_html_e( '- None -', 'bunchy' ); ?></option>
						<?php foreach ( $bunchy_tags as $bunchy_tag_slug => $bunchy_tag_name ) : ?>
							<option
								value="<?php echo esc_attr( $bunchy_tag_slug ); ?>"
								<?php selected( in_array( $bunchy_tag_slug, $bunchy_selected_tags, true ) ); ?>>
								<?php echo esc_html( $bunchy_tag_name ); ?></option>
						<?php endforeach; ?>
					</select>
				</p>

				<p>
					<label><?php esc_html_e( 'Hide elements', 'bunchy' ); ?>:</label><br/>

					<input class="checkbox" type="checkbox" <?php checked( $instance['entry_featured_media'], false ) ?>
					       id="<?php echo esc_attr( $this->get_field_id( 'entry_featured_media' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'entry_featured_media' ) ); ?>"/>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'entry_featured_media' ) ); ?>"><?php esc_html_e( 'featured media', 'bunchy' ); ?></label><br/>

					<input class="checkbox" type="checkbox" <?php checked( $instance['entry_categories'], false ) ?>
					       id="<?php echo esc_attr( $this->get_field_id( 'entry_categories' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'entry_categories' ) ); ?>"/>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'entry_categories' ) ); ?>"><?php esc_html_e( 'categories', 'bunchy' ); ?></label><br/>

					<input class="checkbox" type="checkbox" <?php checked( $instance['entry_summary'], false ) ?>
					       id="<?php echo esc_attr( $this->get_field_id( 'entry_summary' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'entry_summary' ) ); ?>"/>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'entry_summary' ) ); ?>"><?php esc_html_e( 'summary', 'bunchy' ); ?></label><br/>

					<input class="checkbox" type="checkbox" <?php checked( $instance['entry_author'], false ) ?>
					       id="<?php echo esc_attr( $this->get_field_id( 'entry_author' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'entry_author' ) ); ?>"/>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'entry_author' ) ); ?>"><?php esc_html_e( 'author', 'bunchy' ); ?></label><br/>

					<input class="checkbox" type="checkbox" <?php checked( $instance['entry_avatar'], false ) ?>
					       id="<?php echo esc_attr( $this->get_field_id( 'entry_avatar' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'entry_avatar' ) ); ?>"/>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'entry_avatar' ) ); ?>"><?php esc_html_e( 'avatar', 'bunchy' ); ?></label><br/>

					<input class="checkbox" type="checkbox" <?php checked( $instance['entry_date'], false ) ?>
					       id="<?php echo esc_attr( $this->get_field_id( 'entry_date' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'entry_date' ) ); ?>"/>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'entry_date' ) ); ?>"><?php esc_html_e( 'date', 'bunchy' ); ?></label><br/>

					<input class="checkbox" type="checkbox" <?php checked( $instance['entry_shares'], false ) ?>
					       id="<?php echo esc_attr( $this->get_field_id( 'entry_shares' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'entry_shares' ) ); ?>"/>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'entry_shares' ) ); ?>"><?php esc_html_e( 'shares', 'bunchy' ); ?></label><br/>

					<input class="checkbox" type="checkbox" <?php checked( $instance['entry_views'], false ) ?>
					       id="<?php echo esc_attr( $this->get_field_id( 'entry_views' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'entry_views' ) ); ?>"/>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'entry_views' ) ); ?>"><?php esc_html_e( 'views', 'bunchy' ); ?></label><br/>

					<input class="checkbox" type="checkbox" <?php checked( $instance['entry_comments_link'], false ) ?>
					       id="<?php echo esc_attr( $this->get_field_id( 'entry_comments_link' ) ); ?>"
					       name="<?php echo esc_attr( $this->get_field_name( 'entry_comments_link' ) ); ?>"/>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'entry_comments_link' ) ); ?>"><?php esc_html_e( 'comments link', 'bunchy' ); ?></label><br/>
				</p>

				<p>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php esc_html_e( 'HTML id attribute (optional)', 'bunchy' ); ?>
						:</label>
					<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>"
					       id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"
					       value="<?php echo esc_attr( $instance['id'] ) ?>"/>
				</p>

				<p>
					<label
						for="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>"><?php esc_html_e( 'HTML class(es) attribute (optional)', 'bunchy' ); ?>
						:</label>
					<input class="widefat" type="text"
					       name="<?php echo esc_attr( $this->get_field_name( 'class' ) ); ?>"
					       id="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>"
					       value="<?php echo esc_attr( $instance['class'] ) ?>"/>
				</p>
			</div>
			<?php
		}

		/**
		 * Get query arguments
		 *
		 * @param array $instance Instance.
		 *
		 * @return array
		 */
		protected function get_query_args( $instance ) {
			$query_args = array(
				'posts_per_page'      => $instance['max'],
				'ignore_sticky_posts' => true,
			);

			// Time range.
			$query_args = bunchy_time_range_to_date_query( $instance['time_range'], $query_args );

			$bunchy_categories = is_array( $instance['category_slugs'] ) ? array_filter( $instance['category_slugs'] ) : array(); // Remove empty value with array_filter.

			// Categories.
			if ( ! empty( $bunchy_categories ) ) {
				$query_args['category_name'] = implode( ',', $bunchy_categories );
			}

			$bunchy_tags = is_array( $instance['tag_slugs'] ) ? array_filter( $instance['tag_slugs'] ) : array(); // Remove empty values with array_filter.

			// Tags.
			if ( ! empty( $bunchy_tags ) ) {
				$query_args['tag_slug__in'] = $bunchy_tags;
			}

			switch ( $instance['sort_by'] ) {
				case 'date':
					$query_args['orderby'] = 'date';
					break;

				case 'comments':
					$query_args['orderby'] = 'comment_count';
					break;

				case 'views':
					$query_args = bunchy_get_most_viewed_query_args( $query_args, 'widget_posts' );
					break;

				case 'shares':
					$query_args = bunchy_get_most_shared_query_args( $query_args );
					break;
			}

			return apply_filters( 'bunchy_widget_posts_query_args', $query_args );
		}

		/**
		 * Get default arguments
		 *
		 * @return array
		 */
		public function get_default_args() {
			return apply_filters( 'bunchy_widget_posts_defaults', array(
				'title'                => esc_html__( 'Trending Now', 'bunchy' ),
				'max'                  => 6,
				'template'             => 'standard',
				'sort_by'              => 'date',
				'time_range'           => 'all',
				'category_slugs'       => array(),
				'tag_slugs'            => array(),
				'entry_featured_media' => true,
				'entry_avatar'         => true,
				'entry_categories'     => true,
				'entry_title'          => true,
				'entry_summary'        => true,
				'entry_author'         => true,
				'entry_date'           => true,
				'entry_shares'         => true,
				'entry_views'          => true,
				'entry_comments_link'  => true,
				'id'                   => '',
				'class'                => '',
			) );
		}

		/**
		 * Update widget
		 *
		 * @param array $new_instance New instance.
		 * @param array $old_instance Old instance.
		 *
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['title']                = strip_tags( $new_instance['title'] );
			$instance['max']                  = absint( $new_instance['max'] );
			$instance['template']             = in_array( $new_instance['template'], array(
				'standard',
				'numbered',
			), true ) ? $new_instance['template'] : 'standard';
			$instance['sort_by']              = in_array( $new_instance['sort_by'], array(
				'date',
				'comments',
				'views',
				'shares',
			), true ) ? $new_instance['sort_by'] : 'date';
			$instance['time_range']           = in_array( $new_instance['time_range'], array(
				'day',
				'week',
				'month',
				'all',
			), true ) ? $new_instance['time_range'] : 'all';
			$instance['category_slugs']       = array_filter( $new_instance['category_slugs'], 'is_string' );
			$instance['tag_slugs']            = array_filter( $new_instance['tag_slugs'], 'is_string' );
			$instance['entry_featured_media'] = empty( $new_instance['entry_featured_media'] );
			$instance['entry_avatar']         = empty( $new_instance['entry_avatar'] );
			$instance['entry_categories']     = empty( $new_instance['entry_categories'] );
			$instance['entry_title']          = empty( $new_instance['entry_title'] );
			$instance['entry_summary']        = empty( $new_instance['entry_summary'] );
			$instance['entry_author']         = empty( $new_instance['entry_author'] );
			$instance['entry_date']           = empty( $new_instance['entry_date'] );
			$instance['entry_shares']         = empty( $new_instance['entry_shares'] );
			$instance['entry_views']          = empty( $new_instance['entry_views'] );
			$instance['entry_comments_link']  = empty( $new_instance['entry_comments_link'] );
			$instance['id']                   = sanitize_html_class( $new_instance['id'] );
			$instance['class']                = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $new_instance['class'] ) ) );

			return $instance;
		}
	}

endif;
