<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/11/2022
 * Time: 11:09 AM
 */
class Team extends epBase
{
    public function getFeatureImage()
    {
        return get_the_post_thumbnail($this->Post, 'team');
    }
    public function getCustomField($field)
    {
        return $this->getPostMeta($field);
    }
    function profile()
    {
        $slug = str_replace(" ", "-", $this->getTitle());
        $slug = strtolower($slug);
        $html = '<div class="inner-wrapper">
            <div class="image-wrapper" onclick="location.href=/' . $slug . '/">
                ' . $this->getFeatureImage() . '
            </div>
            <div class="content-wrapper">
                <h3>' . $this->getTitle() . '</h3>
                <div class="position"><em>' . $this->getCustomField('team-position') . '</em></div>
                <div class="snippet">' . $this->getCustomField('team-snippet') . '</div>
            </div>
            <a href="' . $this->link() . '" class="read-more">Read more</a>
        </div>';
        return $html;
    }
    function previous()
    {
        global $wpdb;
        $sql = '
        SELECT p.ID
        FROM ' . $wpdb->prefix . 'posts p
        WHERE p.menu_order < ' . $this->getMenuPosition() . '
        AND post_status="publish" 
        AND post_type="team"
        ORDER BY p.menu_order DESC
        LIMIT 1';
        $result = $wpdb->get_results($sql);
        $prev_id = $result[0]->ID;
        if($prev_id == "") {
            $sql = '
            SELECT p.ID
            FROM ' . $wpdb->prefix . 'posts p
            WHERE post_status="publish" 
            AND post_type="team"
            ORDER BY p.menu_order DESC
            LIMIT 1';
            $result = $wpdb->get_results($sql);
            $prev_id = $result[0]->ID;
        }
        return new Team($prev_id);
    }
    function next()
    {
        global $wpdb;
        $sql = '
        SELECT p.ID
        FROM ' . $wpdb->prefix . 'posts p
        WHERE p.menu_order > ' . $this->getMenuPosition() . '
        AND post_status="publish" 
        AND post_type="team"
        ORDER BY p.menu_order ASC
        LIMIT 1';
        $result = $wpdb->get_results($sql);
        $next_id = $result[0]->ID;
        if($next_id =="") {
            $sql = '
            SELECT p.ID
            FROM ' . $wpdb->prefix . 'posts p
            WHERE post_status="publish" 
            AND post_type="team"
            ORDER BY p.menu_order ASC
            LIMIT 1';
            $result = $wpdb->get_results($sql);
            $next_id = $result[0]->ID;
        }
        return new Team($next_id);
    }
    function getCategory()
    {
        global $wpdb;

        $sql = '
        SELECT t.term_id
        FROM ' . $wpdb->prefix . 'term_relationships tr
        INNER JOIN ' . $wpdb->prefix . 'term_taxonomy t
        ON tr.term_taxonomy_id = t.term_taxonomy_id
        WHERE object_id = ' . $this->id();
        $result = $wpdb->get_results($sql);

        return new Category($result[0]->term_id);
    }
}