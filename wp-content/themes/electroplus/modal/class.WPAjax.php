<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/10/2022
 * Time: 2:02 PM
 */
class WPAjax
{
    private $success = 0;
    private $error = 0;
    private $response = 0;

    function __construct($function)
    {
        if (method_exists($this, $function)) {
            // Runt he function
            $this->$function();
        } else {
            $this->error = 1;
            $this->response = 'Function not found for ' . $function;
        }
        echo $this->getResponse();
        session_write_close();
        exit;
    }

    public function getResponse()
    {
        // Prepare response array
        $json = Array(
            'success' => $this->success,
            'error' => $this->error,
            'response' => $this->response
        );
        $output = $json['response'];

        return $output;
    }
    function filterProjects()
    {
        $gallery_id = $_REQUEST['gallery_id'];
        $this->response = projectGallery($gallery_id);
    }
    function updateModalSlides()
    {
        $gallery_id = $_REQUEST['gallery_id'];
        $this->response = modalSlides($gallery_id);
    }
}