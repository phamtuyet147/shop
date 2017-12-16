<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 10/8/2017
 * Time: 5:04 PM
 */

namespace core\app;


use core\processor\AppRouting;
use core\processor\ViewConfig;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use Exception;
use SimpleXMLElement;

class AppView implements AppController
{
    /**
     * @var SimpleXMLElement $views
     */
    private $views;

    /**
     * @param SimpleXMLElement $views
     */
    public function setViews($views)
    {
        $views = new SimpleXMLElement($views->asXML());
        $this->views = $views;
    }

    public function doView($name)
    {
        try {
            if (empty($this->views)) {
                throw new Exception('This controller do not have any view');
            }
            $view = $this->views->xpath("/views/view[@on='{$name}']");
            if (empty($view)) {
                throw new Exception('Could not init view: ' . $name);
            }
            $view = $view[0];
            if (empty($view['action'])) {
                throw new Exception('Could not init view: ' . $name);
            }
            $action = (string)$view['action'];
            $action = trim($action, '/');
            $action = '/' . $action;
            if (!empty($view['redirect']) && $view['redirect'] == true) {
                HTTPResponse::redirect($action);
            }
            HTTPRequest::setPagePath($action);
            AppRouting::runApp(new HTTPRequest(), new HTTPResponse());
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }

    /**
     * Controller constructor.
     *
     * @param HTTPRequest $request
     * @param HTTPResponse $response
     */
    public function __construct(HTTPRequest $request, HTTPResponse $response)
    {
    }

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     *
     * @throws Exception
     */
    public function execute(HTTPRequest $request, HTTPResponse $response,
                            AppView $appView
    )
    {
        $pagePath = $request->getPagePath();
        ViewConfig::initView($pagePath);
    }
}