<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/3/2022
 * Time: 1:51 PM
 */
class Service extends epBase
{
    public function getFeatureImage()
    {
        return get_the_post_thumbnail($this->Post, 'grid');
    }
    public function getCustomField($field)
    {
        return $this->getPostMeta($field);
    }
    function getBannerImage()
    {
        $html = '<img src="' . $this->getPostMeta('service-banner-image') . '" alt="' . $this->getTitle() . '" />';

        return $html;
    }
}