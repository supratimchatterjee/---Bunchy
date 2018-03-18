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

		<?php if ( $bunchy_elements['author'] || $bunchy_elements['date'] ) : ?>

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
			</p>
		<?php endif; ?>

		<?php the_title( '<h1 class="g1-mega g1-mega-1st entry-title" itemprop="headline">', '</h1>' ); ?>

		<?php
		if ( bunchy_can_use_plugin( 'wp-subtitle/wp-subtitle.php' ) ) :
			the_subtitle( '<h2 class="entry-subtitle g1-gamma g1-gamma-3rd">', '</h2>' );
		endif;
		?>

		<?php get_template_part( 'template-parts/snax-bar-item' ); ?>
	</header>

	<div class="entry-content g1-typography-xl g1-indent">

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
	</div>

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
		<meta itemprop="name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
		<span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
			<meta itemprop="url"
			      content="http://bunchy.bringthepixel.com/wp-content/uploads/2015/11/wow_06_v01-192x96.jpg"/>
		</span>
	</span>
</article>
