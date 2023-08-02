<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/11/2022
 * Time: 8:57 PM
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
    <div class="wrapper" id="page-wrapper">
        <div id="content" class="container">
            <div class="row">
                <div class="col-12">
                    <main class="site-main" id="main">
                        <?=get_template_part('loop-templates/content', 'team')?>
                    </main>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
