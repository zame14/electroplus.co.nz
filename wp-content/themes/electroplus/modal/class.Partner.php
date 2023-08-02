<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/8/2022
 * Time: 11:10 AM
 */
class Partner extends epBase
{
    function getLogo()
    {
        return $this->getPostMeta('partner-logo');
    }
}