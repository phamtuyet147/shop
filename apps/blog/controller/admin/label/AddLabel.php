<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 12/11/2017
 * Time: 5:53 AM
 */

namespace apps\blog\controller\admin\label;


use apps\blog\controller\BaseBlogJson;
use apps\blog\model\dao\LabelDAO;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use core\utils\StringUtils;

class AddLabel extends BaseBlogJson
{
    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     *
     * @return mixed
     */
    public function executeImpl(HTTPRequest $request,
        HTTPResponse $response
    ) {
        $labelName = $request->getPostParam('label');
        $labelTag = StringUtils::convertStringToURL($labelName);

        $label = LabelDAO::getLabelByTagName($labelTag);
        if ($label) {
            $labelTag .= '-' . time();
            $labelName .= ' ' . time();
        }

        LabelDAO::createLabel($labelTag, $labelName);

        $responseData = parent::$RESPONSE_DATA['success'];
        $responseData['data'] = array(
            'tag'   => $labelTag,
            'title' => $labelName
        );

        return $responseData;
    }
}