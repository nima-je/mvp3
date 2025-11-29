<?php
/**
 * Search results template
 *
 * @package LinkShop
 */

get_header();
?>
<div class="ls-container">
    <header class="search-header">
        <h1><?php printf( esc_html__( 'نتایج برای: %s', 'linkshop' ), get_search_query() ); ?></h1>
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
        <p><?php esc_html_e( 'نتیجه‌ای یافت نشد.', 'linkshop' ); ?></p>
    <?php endif; ?>
</div>
<?php
get_footer();
