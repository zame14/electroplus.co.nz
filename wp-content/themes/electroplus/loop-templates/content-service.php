<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/8/2022
 * Time: 1:22 PM
 */
global $post;
$service = new Service($post->ID);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?=$service->getContent(true)?>
</article>
