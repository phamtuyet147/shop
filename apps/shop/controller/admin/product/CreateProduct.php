<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/14/2018
 * Time: 11:59 PM
 */

namespace apps\shop\controller\admin\product;


use apps\shop\controller\BaseAction;
use apps\shop\model\dao\CategoryDAO;
use apps\shop\model\dao\ProductDAO;
use apps\shop\util\ShopSetting;
use core\app\AppView;
use core\utils\AppInfo;
use core\utils\HashUtil;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use core\utils\StringUtils;

class CreateProduct extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        if (!$request->isPost()) {
            $categories = CategoryDAO::getTopCategories();
            $request->setAttribute('categories', $categories);
            $appView->doView('success');
        }
    }

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doPost(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $categoryId = $request->getParameter('id_category');
        $title = $request->getParameter('title');
        $price = $request->getParameter('price');
        $shortDesc = $request->getParameter('short_desc');
        $desc = $request->getParameter('desc');
        $pictures = $request->getFileParam('pictures');

        foreach ($pictures['error'] as $error) {
            if ($error != UPLOAD_ERR_OK) {
                $request->setAttribute(
                    'wError', 'Hình ảnh không hợp lệ hoặc đã bị lỗi'
                );
                $appView->doView('success');
            }
        }

        //Check file type
        $thumbnail = array();
        $uploadDir = W_ROOT . ShopSetting::getUploadDir() . DIRECTORY_SEPARATOR;
        $allowedExt = ShopSetting::getAllowedProductImageExt();
        $allowedType = ShopSetting::getAllowedProductImageType();
        $allowedExt = explode(',', $allowedExt);
        $allowedType = explode(',', $allowedType);
        foreach ($pictures['type'] as $fileType) {
            if (!in_array($fileType, $allowedType)) {
                $request->setAttribute('wError', 'Hình ảnh không hợp lệ');
                $appView->doView('success');
            }
        }
        foreach ($pictures['name'] as $index => $fileName) {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowedExt)) {
                $request->setAttribute('wError', 'Hình ảnh không hợp lệ');
                $appView->doView('success');
            }
            $newName = HashUtil::randomHash();
            $newName .= ".{$ext}";
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    $request->setAttribute('wError', 'Lỗi khi upload file');
                    $appView->doView('success');
                }
            }
            if (!move_uploaded_file(
                $pictures['tmp_name'][$index], $uploadDir . $newName
            )
            ) {
                $request->setAttribute('wError', 'Lỗi khi upload file');
                $appView->doView('success');
            }
            $thumbnail[] = AppInfo::$REQ_URL . ShopSetting::getUploadDir()
                . "/$newName";
        }

        //Create short tag
        $shortTag = StringUtils::convertStringToURL($title);
        ProductDAO::createProduct(
            $categoryId, $title, $shortTag, $price, $shortDesc, $desc,
            implode(',', $thumbnail)
        );

        $appView->doView('created');
    }
}