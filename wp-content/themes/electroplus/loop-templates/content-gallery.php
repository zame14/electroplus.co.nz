<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/10/2022
 * Time: 9:58 AM
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_content(); ?>
    <div class="gallery-section ani-in">
        <?=projectGallery(0)?>
    </div>
</article>
<div id="projectModal" class="modal">
    <span class="fa fa-times" onclick="closeModal()"></span>
    <div class="modal-content">
        <?=modalSlides(0)?>
    </div>
</div>