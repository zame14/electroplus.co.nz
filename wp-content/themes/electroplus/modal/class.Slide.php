<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/3/2022
 * Time: 11:23 AM
 */
class Slide extends epBase
{
    function getImage()
    {
        $html = '<img src="' . $this->getPostMeta('the-slide-image') . '" alt="' . $this->getTitle() . '" />';
        return $html;
    }
    public function photoCredit()
    {
        $html = '';
        if($this->getPostMeta('photo-credit') <> "") {
            $html = $this->getPostMeta('photo-credit');
        }
        return $html;
    }
}