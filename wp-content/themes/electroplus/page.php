<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();
global $post;
$page_title = get_the_title();
?>
<div class="wrapper" id="page-wrapper">
<?php
if (is_front_page()) {
    $slider = new Slider(39);
    $slides = $slider->getSlides();
    shuffle($slides);
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 no-padding">
                <div class="home-banner-wrapper ani-in">
                    <div class="image-slider">
                        <?php
                        foreach($slides as $slide) { ?>
                            <div class="slide">
                                <div class="image-wrapper">
                                    <?=$slide->getImage()?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="banner-content-wrapper container ani-in">
                        <?=get_field('home_banner_content', 5)?>
                    </div>
                    <?php
                    if(get_field('photo_credit', $post->ID)) { ?>
                        <div class="photo-credit">
                            &copy; <?=get_field('photo_credit', $post->ID)?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php } else {
        if (has_post_thumbnail($post->ID)) { ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 no-padding">
                    <div class="inside-banner-wrapper">
                        <?= get_the_post_thumbnail($post->ID, 'full') ?>
                        <div class="page-title">
                            <h1><?= $page_title ?></h1>
                        </div>
                        <?php
                        if (get_field('photo_credit', $post->ID)) {
                            ?>
                            <div class="photo-credit">
                                &copy; <?= get_field('photo_credit', $post->ID) ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        } else {

            ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="no-banner-wrapper">
                            <div class="page-title">
                                <h1><?= $page_title ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    }?>
    <div id="content" class="container">
        <div class="row">
            <div class="col-12">
                <main class="site-main" id="main">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    switch ($post->ID) {
                        case 106:
                            get_template_part('loop-templates/content', 'gallery');
                            break;
                        default:
                            get_template_part('loop-templates/content', 'page');
                    }
                    ?>
                <?php endwhile; // end of the loop. ?>
                </main>
            </div>
        </div>
    </div>
</div><!-- #page-wrapper -->
<?php
get_footer();
