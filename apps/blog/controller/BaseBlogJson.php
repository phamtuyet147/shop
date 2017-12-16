<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 12/11/2017
 * Time: 5:54 AM
 */

namespace apps\blog\controller;


use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use core\utils\LangUtil;

abstract class BaseBlogJson extends BaseBlogController
{
    protected static $RESPONSE_DATA
        = array(
            'success'        => array(
                'code' => 200,
                'msg'  => 'Thành công'
            ),
            'recordNotFound' => array(
                'code' => 404,
                'msg'  => 'Không tìm thấy dữ liệu'
            ),
            'missParam'      => array(
                'code' => 400,
                'msg'  => 'Vui lòng nhập đầy đủ thông tin cần thiết'
            ),
            'unknown'        => array(
                'code' => 500,
                'msg'  => 'Đã xảy ra lỗi. Vui lòng liên hệ kỹ thuật viên'
            )
        );

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     *
     */
    public function execute(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $responseData = $this->executeImpl($request, $response);
        if (!empty($responseData['msg'])) {
            $responseData['msg'] = LangUtil::getMessage($responseData['msg']);
        }

        $response->setContent(json_encode($responseData));
    }

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     *
     * @return mixed
     */
    abstract public function executeImpl(HTTPRequest $request,
        HTTPResponse $response
    );
}