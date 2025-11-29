<?php
/**
 * Front page template
 *
 * @package LinkShop
 */

get_header();
?>
<div class="ls-hero ls-container">
    <div class="ls-hero__content">
        <h1><?php bloginfo( 'name' ); ?></h1>
        <p><?php bloginfo( 'description' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'مشاهده فروشگاه', 'linkshop' ); ?></a>
    </div>
</div>

<div class="ls-container ls-front-grid">
    <section>
        <h2><?php esc_html_e( 'آخرین نوشته‌ها', 'linkshop' ); ?></h2>
        <div class="ls-grid">
            <?php
            $posts = new WP_Query( array( 'posts_per_page' => 3 ) );
            if ( $posts->have_posts() ) :
                while ( $posts->have_posts() ) : $posts->the_post();
                    ?>
                    <article class="ls-card ls-post-card">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>' . esc_html__( 'مطلبی یافت نشد.', 'linkshop' ) . '</p>';
            endif;
            ?>
        </div>
    </section>
</div>
<?php
get_footer();
