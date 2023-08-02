<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/3/2022
 * Time: 11:22 AM
 */
class Slider extends epBase
{
    function getSlides()
    {
        $slides = array();
        $query = new WP_Query(
            array(
                'post_type' => 'slide',
                'toolset_relationships' => array(
                    'role' => 'child',
                    'related_to' => $this->id(), // ID of starting post
                    'relationship' =>'image-slide',
                ),
                'order_by' => 'ID',
                'order' => 'ASC'
            )
        );
        foreach($query->posts as $post)
        {
            $slide = new Slide($post->ID);
            $slides[] = $slide;
        }
        return $slides;
    }
}