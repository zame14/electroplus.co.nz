<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
global $post;
$cta = get_field('show_footer_cta',$post->ID);
$post_type = get_post_type($post->ID);
if($cta[0] == 1 || $post_type == "team") { ?>
    <section id="footer-cta">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    if(is_active_sidebar('footerctawidget')){
                        dynamic_sidebar('footerctawidget');
                    }
                    ?>
                    <?=do_shortcode('[question_buttons]')?>
                </div>
            </div>
        </div>
    </section>
<?php
}
if($post->ID <> 5) { ?>
    <div class="home-section-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?= do_shortcode('[partners]') ?>
                </div>
            </div>
        </div>
    </div>
    <?php
} else { ?>
    <div class="home-cta-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?= do_shortcode('[home-cta]') ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<a class="top">
    <span class="fa fa-chevron-up"></span>
</a>
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="inner-wrapper">
                    <div class="f-col-1">
                        <h3>About</h3>
                        <?php
                        if(is_active_sidebar('footerwidget')){
                            dynamic_sidebar('footerwidget');
                        }
                        ?>
                    </div>
                    <div class="f-col-2">
                        <h3>Services</h3>
                        <?=servicesMenu()?>
                    </div>
                    <div class="f-col-3">
                        <h3>Contact</h3>
                        <address><?=get_field('address')?></address>
                        <ul>
                            <li class="ph"><label>P:</label><a href="tel:<?=formatPhoneNumber(get_field('phone', 5))?>"><?=get_field('phone', 5)?></a></li>
                            <li class="email"><label>E:</label><a href="mailto:<?=get_field('email', 5)?>"><?=get_field('email', 5)?></a></li>
                            <li>Open <?=get_field('office_hours', 5)?></li>
                        </ul>
                        <?=socialMedia()?>
                        <a href="<?=get_page_link(251)?>" class="site-map"><span class="fa fa-sitemap"></span>Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="copyright">
                    <ul>
                        <li>&copy; Copyright <?=date('Y')?> <?=get_bloginfo('name')?></li>
                        <li class="site-by">Custom Website by <a href="https://www.azwebsolutions.co.nz/" target="_blank">A-Z Web Solutions<span class="az"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
</div><!-- #page we need this extra closing tag here -->
<?php wp_footer(); ?>
<script type="text/javascript" src="<?=get_stylesheet_directory_uri()?>/slick-carousel/slick/slick.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/js/noframework.waypoints.min.js" type="text/javascript"></script>
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/js/theme.js" type="text/javascript"></script>
</body>
</html>

