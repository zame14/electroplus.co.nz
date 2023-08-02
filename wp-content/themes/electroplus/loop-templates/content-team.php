<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/11/2022
 * Time: 9:05 PM
 */
global $post;
$team = new Team($post->ID);
$previous = $team->previous();
$next = $team->next();
$category = $team->getCategory();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4">
            <div class="image-wrapper">
                <?=$team->getFeatureImage()?>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-8 content-wrapper">
            <div class="category-name"><?=$category->Term->name?> Team</div>
            <h1><?=$team->getTitle()?></h1>
            <div class="position"><em><?=$team->getCustomField('team-position')?></em></div>
            <div class="bio"><?=$team->getContent()?></div>
        </div>
    </div>
    <div class="row team-navigation-wrapper">
        <div class="col-12">
            <ul>
                <li><a class="previous-team" href="<?=$previous->link()?>"><span class="fa fa-angle-left"></span><strong><?=$previous->getTitle()?></strong></a></li>
                <li><a href="<?=get_page_link(14)?>#team"><span class="fa fa-th"></span></a></li>
                <li><a class="next-team" href="<?=$next->link()?>"><strong><?=$next->getTitle()?></strong><span class="fa fa-angle-right"></span></a></li>
            </ul>
        </div>
    </div>
</article>