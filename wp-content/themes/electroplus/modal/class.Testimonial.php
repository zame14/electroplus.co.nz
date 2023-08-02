<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/8/2022
 * Time: 9:31 AM
 */
class Testimonial extends epBase
{
    public function getCustomField($field)
    {
        return $this->getPostMeta($field);
    }
    function getRating() {
        $class = 'fa fa-star-o';
        $html = '<ul class="stars">';
        for($i=0; $i < 5; $i++) {
            $class = 'fa fa-star-o';
            if($i < $this->getPostMeta('t-star-rating')) {
                $class = 'fa fa-star';
            }
            $html .= '<li><span class="' . $class . '"></span></li>';
        }
        $html .= '</ul>';
        return $html;
    }
    function getPanel()
    {
        $html = '<div class="inner-wrapper">
            ' . $this->getRating() . '
            <div class="description">
                ' . $this->getTeaser() . '
            </div>
            <div class="author">
                ' . $this->getTitle() . '
            </div>
        </div>';
        return $html;
    }
    function cfIsSet($meta)
    {
        if($this->getCustomField($meta) <> "") {
            return true;
        } else {
            return false;
        }
    }
    public function getTeaser()
    {
        $html = '';
        $anchor = str_replace(" ","-",$this->getTitle());
        $anchor = strtolower($anchor);
        if(strlen($this->getContent()) > 200) {
            $html = substr($this->getContent(),0,200) . '...<a href="' . get_page_link(16) . '#' . $anchor . '"> read more</a>';
        } else {
            $html = $this->getContent();
        }
        return $html;
    }
}