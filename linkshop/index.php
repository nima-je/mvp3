<?php
/**
 * Main template file
 *
 * @package LinkShop
 */

get_header();
?>
<div class="ls-container">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'ls-article' ); ?>>
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e( 'محتوایی یافت نشد.', 'linkshop' ); ?></p>
    <?php endif; ?>
</div>
<?php
get_footer();
