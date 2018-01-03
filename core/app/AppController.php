<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/16/2017
 * Time: 5:02 PM
 */

namespace core\app;


use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

interface AppController
{
    /**
     * Controller constructor.
     *
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     */
    public function __construct(HTTPRequest $request, HTTPResponse $response);

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    );

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doPost(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    );
}