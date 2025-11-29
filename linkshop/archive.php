<?php
/**
 * Archive template
 *
 * @package LinkShop
 */

get_header();
?>
<div class="ls-container">
    <header class="archive-header">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
        <div class="archive-description"><?php the_archive_description(); ?></div>
    </header>

    <?php if ( have_posts() ) : ?>
        <div class="ls-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'ls-card ls-post-card' ); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php echo wp_trim_words( get_the_excerpt(), 25 ); ?></p>
                </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e( 'موردی یافت نشد.', 'linkshop' ); ?></p>
    <?php endif; ?>
</div>
<?php
get_footer();
