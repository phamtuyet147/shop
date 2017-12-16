<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/16/2017
 * Time: 3:47 PM
 */

namespace core\app;


use core\processor\Filters;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

interface AppFilter
{
    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param Filters      $filters
     *
     */
    public function doFilter(HTTPRequest $request, HTTPResponse $response,
        Filters $filters
    );
}