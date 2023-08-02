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
$service = new Service($post->ID);
?>
<div class="wrapper" id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 no-padding">
                <div class="inside-banner-wrapper">
                    <?= $service->getBannerImage() ?>
                    <div class="page-title ani-in">
                        <h1><?= $service->getTitle() ?></h1>
                    </div>
                    <?php
                    if(get_field('photo_credit', $post->ID)) { ?>
                        <div class="photo-credit">
                            &copy; <?= get_field('photo_credit', $service->id()) ?>
                        </div>
                        <?php
                    }
                        ?>
                </div>
            </div>
        </div>
    </div>
    <div id="content" class="container">
        <div class="row">
            <div class="col-12">
                <main class="site-main" id="main">
                    <?=get_template_part('loop-templates/content', 'service')?>
                </main>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();