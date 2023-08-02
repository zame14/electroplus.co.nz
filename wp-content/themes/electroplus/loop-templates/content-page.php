<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/2/2022
 * Time: 8:18 PM
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_content(); ?>
</article>