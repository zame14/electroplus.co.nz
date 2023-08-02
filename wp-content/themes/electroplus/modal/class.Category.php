<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/11/2022
 * Time: 11:14 AM
 */
class Category
{
    public $Term = null;

    function __construct($term)
    {
        // If an ID is passed instead then change for a post array
        if(intval($term)) $term = get_term($term);
        $this->Term = $term;
    }

    public function id() {
        return $this->Term->term_id;
    }

    function getTermMeta($meta, $prefix = true) {
        if($prefix) $meta = 'wpcf-' . $meta;
        return get_term_meta($this->Term->term_id, $meta, true);
    }


    public function getTitle()
    {
        $title = $this->Term->name;
        return $title;
    }
}