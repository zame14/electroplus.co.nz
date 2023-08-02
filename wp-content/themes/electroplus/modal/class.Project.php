<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/10/2022
 * Time: 9:48 AM
 */
class Project extends epBase
{
    public function getProjectImages()
    {
        $gallery = Array();
        $field = get_post_meta($this->id());
        foreach($field['wpcf-project-images'] as $image) {
            $gallery[] = $image;
        }
        return $gallery;
    }
}