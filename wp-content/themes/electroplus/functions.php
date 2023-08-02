<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
require_once('modal/class.Base.php');
require_once('modal/class.Slider.php');
require_once('modal/class.Slide.php');
require_once('modal/class.Service.php');
require_once('modal/class.Testimonial.php');
require_once('modal/class.Partner.php');
require_once('modal/class.Project.php');
require_once('modal/class.Team.php');
require_once('modal/class.Category.php');
require_once('modal/class.WPAjax.php');
add_action( 'wp_enqueue_scripts', 'p_enqueue_styles');
function p_enqueue_styles() {
    //wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/slick-carousel/slick/slick.css');
    wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/slick-carousel/slick/slick-theme.css');
    wp_enqueue_style( 'understrap-theme', get_stylesheet_directory_uri() . '/style.css');
}
add_image_size( 'grid', 600, 400, true);
add_image_size( 'team', 400, 500, true);
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );
function dg_remove_page_templates( $templates ) {
    unset( $templates['page-templates/blank.php'] );
    unset( $templates['page-templates/right-sidebarpage.php'] );
    unset( $templates['page-templates/both-sidebarspage.php'] );
    unset( $templates['page-templates/empty.php'] );
    unset( $templates['page-templates/fullwidthpage.php'] );
    unset( $templates['page-templates/left-sidebarpage.php'] );
    unset( $templates['page-templates/right-sidebarpage.php'] );

    return $templates;
}
add_filter( 'theme_page_templates', 'dg_remove_page_templates' );
function formatPhoneNumber($ph) {
    $ph = str_replace('(', '', $ph);
    $ph = str_replace(')', '', $ph);
    $ph = str_replace(' ', '', $ph);
    $ph = str_replace('+64', '0', $ph);

    return $ph;
}
function getImageID($image_url)
{
    global $wpdb;
    $sql = 'SELECT ID FROM ' . $wpdb->prefix . 'posts WHERE guid = "' . $image_url . '"';
    $result = $wpdb->get_results($sql);

    return $result[0]->ID;
}
function socialMedia()
{
    $html = '<ul class="social-media">
        <li><a href="' . get_field('facebook_url', 5) . '" target="_blank"><span class="fa fa-facebook"></span></a></li>
        <li><a href="' . get_field('instagram_url', 5) . '" target="_blank"><span class="fa fa-instagram"></span></a></li>
    </ul>';
    return $html;
}
function getServices()
{
    $services = Array();
    $posts_array = get_posts([
        'post_type' => 'service',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'ASC',
    ]);
    foreach ($posts_array as $post) {
        $service = new Service($post);
        $services[] = $service;
    }
    return $services;
}
function serviceTiles_shortcode()
{
    $html = '<div class="row">';
    foreach (getServices() as $service) {
        $slug = str_replace(" ", "-", $service->getTitle());
        $slug = strtolower($slug);
        $html .= '<div class="col-12 col-sm-6 service-tile">
            <div class="inner-wrapper">
                <div class="image-wrapper" onclick="location.href=/' . $slug . '/">
                    ' . $service->getFeatureImage() . '
                </div>
                <div class="content-wrapper">
                    <h3>' . $service->getTitle() . '</h3>
                    <div class="snippet">
                        ' . $service->getCustomField('service-snippet') . '
                    </div>
                </div>
                <a href="' . $service->link() . '" class="learn-more">' . $service->getCustomField('service-link-label') . '</a>
            </div>    
        </div>';
    }
    $html .= '
    </div>';
    return $html;
}
add_shortcode('service_tiles','serviceTiles_shortcode');
function servicesMenu()
{
    $html = '<ul>';
    foreach (getServices() as $service) {
        $html .= '<li><a href="' . $service->link() . '">' . $service->getTitle() . '</a></li>';
    }
    $html .= '</ul>';
    return $html;
}
function getTestimonials($limit = -1)
{
    $arr = Array();
    $posts_array = get_posts([
        'post_type' => 'testimonial',
        'post_status' => 'publish',
        'numberposts' => $limit,
        'orderby' => 'ID',
        'order' => 'ASC',
    ]);
    foreach ($posts_array as $post) {
        $testimony = new Testimonial($post);
        $arr[] = $testimony;
    }
    return $arr;
}
function testimonialSlider_shortcode()
{
    $testimonials = getTestimonials();
    shuffle($testimonials);
    $html = '<div class="testimonial-slider">';
        foreach($testimonials as $testimonial)
        {
            $html .= '<div>' . $testimonial->getPanel() . '</div>';
        }
    $html .= '    
    </div>';
    return $html;
}
add_shortcode('testimonial_slider', 'testimonialSlider_shortcode');
function getPartners()
{
    $arr = Array();
    $posts_array = get_posts([
        'post_type' => 'partner',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'ASC',
    ]);
    foreach ($posts_array as $post) {
        $partner = new Partner($post);
        $arr[] = $partner;
    }
    return $arr;
}
function partners_shortcode()
{
    $html = '<ul class="partners">';
    foreach (getPartners() as $partner) {
        $html .= '<li><img src="' . $partner->getLogo() . '" alt="' . $partner->getTitle() . '" /></li>';
    }
    $html .= '</ul>';
    return $html;
}
add_shortcode('partners','partners_shortcode');
function getAQuestionButtons_shortcode()
{
    $html = '<ul>
        <li><a href="' . get_page_link(18) . '" class="btn btn-secondary">Request a free quote</a></li>
        <li><a href="tel:' . formatPhoneNumber(get_field('phone', 5)) . '" class="btn btn-primary"><span class="fa fa-phone"></span> Call us</a></li>
    </ul>';
    return $html;
}
add_shortcode('question_buttons','getAQuestionButtons_shortcode');
function socialsButtons_shortcode()
{
    $html = '<ul>
        <li><a href="' . get_field('facebook_url', 5) . '" class="btn btn-primary" target="_blank"><span class="fa fa-facebook-square"></span>Facebook</a></li>
        <li><a href="' . get_field('instagram_url', 5) . '" class="btn btn-secondary" target="_blank"><span class="fa fa-instagram"></span>Instagram</a></li>
    </ul>';
    return $html;
}
add_shortcode('social_buttons','socialsButtons_shortcode');
function serviceMenu_shortcode()
{
    global $post;
    $class = '';
    $html = '<div class="inner-wrapper">';
    foreach (getServices() as $service) {
        $slug = str_replace(" ", "-", $service->getTitle());
        $slug = strtolower($slug);
        $class = '';
        if($post->ID == $service->id()) {
            $class = 'current';
        }
        $html .= '
        <div class="menu-item ' . $class . '" onclick="location.href=/' . $slug . '/">
            ' . $service->getFeatureImage() . '
            <div class="title">' . $service->getTitle() . '</div>
        </div>';
    }
    $html .= '
    </div>';
    return $html;
}
add_shortcode('service_menu', 'serviceMenu_shortcode');
function selectService_shortcode()
{
    global $post;
    $html = '';
    $single = false;
    foreach (getServices() as $service) {
        if($service->id() == $post->ID) {
            $single = true;
            break;
        }
    }
    $html = '<span class="wpcf7-form-control-wrap" data-name="service">
    <select name="service" class="wpcf7-form-control wpcf7-select wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false">';
    if($single) {
        $this_service = new Service($post->ID);
        $html .= '<option value="' . $this_service->getTitle() . '">' . $this_service->getTitle() . '</option>';
    } else {
        $html .= '<option value="">Select a service*</option>';
        foreach (getServices() as $service) {
            $html .= '<option value="' . $service->getTitle() . '">' . $service->getTitle() . '</option>';
        }
    }
    $html .= '
    </select>
    </span>';
    return $html;
}
add_shortcode('select_service', 'selectService_shortcode');
function getProjects()
{
    $projects = Array();
    $posts_array = get_posts([
        'post_type' => 'project',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'ASC'
    ]);
    foreach ($posts_array as $post) {
        $project = new Project($post);
        $projects[] = $project;
    }
    return $projects;
}
function projectGallery($gallery_id)
{
    $project_images = array();
    $arr1 = array();
    $arr2 = array();
    // get residential image
    $residential = new Project(165);
    $commercial = new Project(163);
    $arr1 = $residential->getProjectImages();
    $arr2 = $commercial->getProjectImages();
    $project_images = array_merge($arr1,$arr2);
    if($gallery_id == 1) {
        $project_images = $arr2;
    }
    if($gallery_id == 2) {
        $project_images = $arr1;
    }
    $i = 0;
    //shuffle($project_images);
    //print_r($project_images);
    ($gallery_id == 0) ? $selected1 = 'current' : $selected1 = '';
    ($gallery_id == 1) ? $selected2 = 'current' : $selected2 = '';
    ($gallery_id == 2) ? $selected3 = 'current' : $selected3 = '';
    $html = '<div class="navigation-wrapper">
        <ul>
            <li class="' . $selected1 . '"><a href="javascript:;" onclick="filter(0)">All</a></li>
            <li class="' . $selected2 . '"><a href="javascript:;" onclick="filter(1)">Commercial</a></li>
            <li class="' . $selected3 . '"><a href="javascript:;" onclick="filter(2)">Residential</a></li>
        </ul>
    </div>';
    $html .= '<div class="grid">';
    foreach ($project_images as $images) {
        $imageid = getImageID($images);
        $img = wp_get_attachment_image_src($imageid, 'full');
        $html .= '
        <div class="grid-item">
            <div class="inner-wrapper">
                <img src="' . $img[0] . '" alt="" data-no-lazy="1" class="project-image" onclick="openModal(' . $i . ');" />
                <span class="fa fa-search" onclick="openModal(' . $i . ');"></span>
            </div>
        </div>';
        $i++;
    }
    $html.= '
    </div>';
    return $html;
}
function modalSlides($gallery_id)
{
    $html = '';
    $project_images = array();
    $arr1 = array();
    $arr2 = array();
    // get residential image
    $residential = new Project(165);
    $commercial = new Project(163);
    $arr1 = $residential->getProjectImages();
    $arr2 = $commercial->getProjectImages();
    $project_images = array_merge($arr1,$arr2);
    if($gallery_id == 1) {
        $project_images = $arr2;
    }
    if($gallery_id == 2) {
        $project_images = $arr1;
    }
    foreach ($project_images as $images) {
        $imageid = getImageID($images);
        $img = wp_get_attachment_image_src($imageid, 'full');
        $html .= '<div>
            <img src="' . $img[0] . '" alt="" data-no-lazy="1" />
        </div>';
    }
    return $html;
}
function getTeamByCategory($term_id)
{
    $arr = Array();
    $posts_array = get_posts([
        'post_type' => 'team',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'menu_order',
        'tax_query' => array(
            array(
                'taxonomy' => 'team-category',
                'field' => 'term_id',
                'terms' => $term_id
            )
        )
    ]);
    foreach ($posts_array as $post) {
        $Team = new Team($post);
        $arr[] = $Team;
    }
    return $arr;
}
function teamModule_shortcode()
{
    $html = '';
    $taxonomies = get_terms( array(
        'taxonomy' => 'team-category',
        'orderby' => 'ID',
        'hide_empty' => false
    ) );
    foreach ($taxonomies as $term) {
        $category = new Category($term->term_id);
        $html .='
        <div class="row team-wrapper justify-content-center">
            <div class="col-12 team-category">
                <h3>' . $category->getTitle() . ' Team</h3>
            </div>';
            foreach (getTeamByCategory($category->id()) as $team) {
                $html .= '<div class="col-12 col-sm-6 col-lg-4 team-panel">' . $team->profile() . '</div>';
            }
        $html .= '
        </div>';
    }
    return $html;
}
add_shortcode('team_module', 'teamModule_shortcode');
function companyName_shortcode()
{
    return '<h3>' . get_bloginfo('name') . '</h3>';
}
add_shortcode('company_name', 'companyName_shortcode');
function phone_shortcode()
{
    return '<a href="tel:' . formatPhoneNumber(get_field('phone', 5)) . '">' . get_field('phone', 5) . '</a>';
}
add_shortcode('phone', 'phone_shortcode');
function emailAddress_shortcode()
{
    $html = '<a href="mailto:' . get_field('email', 5) . '">' . get_field('email', 5) . '</a>';
    return $html;
}
add_shortcode('email', 'emailAddress_shortcode');
function testimonialsModule_shortcode()
{
    $html = '';
    $testimonials = getTestimonials();
    shuffle($testimonials);
    foreach ($testimonials as $t) {
        $anchor = str_replace(" ","-",$t->getTitle());
        $anchor = strtolower($anchor);
        $html .= '
        <div class="testimony-wrapper">
            <a name="' . $anchor . '"></a>
            ' . $t->getRating() . '
            <div class="testimony">
                ' . $t->getContent() . '
            </div>
            <div class="author">' . $t->getTitle() . '</div>
        </div>';
    }
    return $html;
}
add_shortcode('testimonials_module', 'testimonialsModule_shortcode');
function footer_widget_init()
{
    register_sidebar( array(
        'name'          => __( 'Footer Widget', 'understrap' ),
        'id'            => 'footerwidget',
        'description'   => 'Widget area in the footer',
        'before_widget'  => '<div class="footer-widget-wrapper">',
        'after_widget'   => '</div><!-- .footer-widget -->',
        'before_title'   => '<h3 class="widget-title">',
        'after_title'    => '</h3>',
    ) );
}
add_action( 'widgets_init', 'footer_widget_init' );
function footer_cta_widget_init()
{
    register_sidebar( array(
        'name'          => __( 'Footer CTA Widget', 'understrap' ),
        'id'            => 'footerctawidget',
        'description'   => 'CTA area in the footer',
        'before_widget'  => '<div class="footer-cta-widget-wrapper">',
        'after_widget'   => '</div><!-- .footer-widget -->',
        'before_title'   => '<h3 class="widget-title">',
        'after_title'    => '</h3>',
    ) );
}
add_action( 'widgets_init', 'footer_cta_widget_init' );
/**************** Ajax **************************/
add_action('wp_head', function() {
    echo '<script type="text/javascript">
       var ajaxurl = "' . admin_url('admin-ajax.php') . '";
     </script>';
});
add_action('wp_ajax_ajax', function() {
    $WPAjax = new WPAjax($_GET['call']);
});
add_action('wp_ajax_nopriv_ajax', function() {
    $WPAjax = new WPAjax($_GET['call']);
});
function homeCTA_shortcode()
{
    $html = '<div class="home-cta">
        <div class="image-wrapper">
            <img src="' . get_field('master_plumber_logo') . '" alt="Master Plumber" />
        </div>
        <div class="content-wrapper">
            We are New Zealand Master Electricians
        </div>
    </div>';
    return $html;
}
add_shortcode('home-cta','homeCTA_shortcode');