<?php
/**
 * The default template for displaying single post content (with sidebar).
 * This is a template part. It must be used within The Loop.
 *
 * @package Bunchy_Theme
 */

$bunchy_entry_data = bunchy_get_template_part_data();
$bunchy_elements   = $bunchy_entry_data['elements'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-tpl-classic' ); ?> itemscope="" itemtype="<?php echo esc_attr( bunchy_get_entry_microdata_itemtype() ); ?>">

	<header class="entry-header">

		<?php
		bunchy_render_entry_stats( array(
			'share_count'   => false,
			'view_count'    => $bunchy_elements['views'],
			'comment_count' => $bunchy_elements['comments_link'],
			'class'         => 'entry-meta-stats-l',
		) );
		?>

		<?php if ( $bunchy_elements['author'] || $bunchy_elements['date'] || $bunchy_elements['categories'] ) : ?>

			<?php if ( $bunchy_elements['author'] && $bunchy_elements['avatar'] ) : ?>
				<p class="entry-meta entry-meta-with-avatar">
			<?php else : ?>
				<p class="entry-meta">
			<?php endif; ?>

				<?php
				if ( $bunchy_elements['author'] ) :
					bunchy_render_entry_author( array(
						'avatar'      => $bunchy_elements['avatar'],
						'avatar_size' => 30,
						'use_microdata' => true,
					) );
				endif;
				?>

				<?php
				if ( $bunchy_elements['date'] ) :
					bunchy_render_entry_date( array(
						'use_microdata' => true,
					) );
				endif;
				?>

				<?php
				if ( $bunchy_elements['categories'] ) :
					bunchy_render_entry_categories( array(
						'use_microdata' => true,
					) );
				endif;
				?>
			</p>
		<?php endif; ?>

		<?php the_title( '<h1 class="g1-mega g1-mega-1st entry-title" itemprop="headline">', '</h1>' ); ?>

		<?php
		if ( bunchy_can_use_plugin( 'wp-subtitle/wp-subtitle.php' ) ) :
			the_subtitle( '<h2 class="entry-subtitle g1-gamma g1-gamma-3rd" itemprop="description">', '</h2>' );
		endif;
		?>

		<?php
		if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) :
			get_template_part( 'template-parts/snax-bar-post' );
		endif;
		?>
	</header>

	<?php
	if ( bunchy_show_entry_featured_media( $bunchy_elements['featured_media'] ) ) :
		bunchy_render_entry_featured_media( array(
			'size'       => 'bunchy-grid-2of3',
			'apply_link' => false,
			'use_microdata' => true,
		) );
	endif;
	?>

	<div class="entry-content g1-typography-xl g1-indent" itemprop="articleBody">

		<?php
		the_content();
		wp_link_pages();
		?>
	</div>

	<div class="entry-after">
		<?php
		if ( $bunchy_elements['tags'] ) :
			bunchy_render_entry_tags();
		endif;
		?>

		<?php
		if ( $bunchy_elements['author_info'] ) :
			get_template_part( 'template-parts/author-info' );
		endif;
		?>

		<?php
		if ( $bunchy_elements['navigation'] ) :
			get_template_part( 'template-parts/nav-single' );
		endif;
		?>

		<?php
		if ( $bunchy_elements['newsletter'] ) :
			get_template_part( 'template-parts/newsletter-after-content' );
		endif;
		?>
	</div>

	<?php get_template_part( 'template-parts/ad-before-related-entries' ); ?>

	<?php
	if ( $bunchy_elements['related_entries'] ) :
		get_template_part( 'template-parts/collection-related' );
	endif;
	?>

	<?php get_template_part( 'template-parts/ad-before-more-from' ); ?>

	<?php
	if ( $bunchy_elements['more_from'] ) :
		get_template_part( 'template-parts/collection-more-from' );
	endif;
	?>


	<?php get_template_part( 'template-parts/ad-before-comments' ); ?>

	<?php if ( $bunchy_elements['comments'] ) : ?>
		<?php if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif; ?>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/ad-before-dont-miss' ); ?>

	<?php
	if ( $bunchy_elements['dont_miss'] ) :
		get_template_part( 'template-parts/collection-dont-miss' );
	endif;
	?>

	<meta itemprop="mainEntityOfPage" content="<?php echo esc_url( get_permalink() ); ?>"/>
	<meta itemprop="dateModified"
	      content="<?php echo esc_attr( get_the_modified_time( 'Y-m-d' ) . 'T' . get_the_modified_time( 'H:i:s' ) ); ?>"/>

	<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
		<meta itemprop="name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
		<span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
			<meta itemprop="url" content="<?php echo esc_url( bunchy_get_microdata_organization_logo_url() ); ?>" />
		</span>
	</span>
</article>
