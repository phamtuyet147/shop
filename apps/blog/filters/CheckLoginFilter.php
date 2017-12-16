<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 11/5/2017
 * Time: 4:46 PM
 */

namespace apps\blog\filters;


use core\app\AppFilter;
use core\processor\Filters;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class CheckLoginFilter implements AppFilter
{

    /**
     * @param HTTPRequest $request
     * @param HTTPResponse $response
     * @param Filters $filters
     *
     */
    public function doFilter(HTTPRequest $request, HTTPResponse $response,
                             Filters $filters
    )
    {
        // TODO: Implement doFilter() method.
    }
}