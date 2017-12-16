<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/2/2017
 * Time: 9:12 AM
 */

namespace apps\ctsv\controller\user\report;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\object\Report;
use apps\ctsv\utils\ReportUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class UpdateReportValuesController extends BaseAppController
{

    /**
     * @param HTTPRequest $request
     * @param HTTPResponse $response
     * @param AppView $appView
     *
     */
    public function execute(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        /** @var Report $report */
        $report = $request->getSession('report');
        if (empty($report)) {
            $response->redirect('/index.php?path=bao-cao');
        }
        $rows = $request->getParameter('rows');
        if (empty($rows)) {
            $request->setAttribute('report', $report);
            $this->raiseError($request, 'Vui lòng nhập dữ liệu');
            $appView->doView('error');
        }
        $reportTemplate = $report->getTemplate();
        foreach ($reportTemplate->getColumns() as $column) {
            if ($column->getColSpan() > 1) {
                continue;
            }
            $columnKey = $column->getColumnKey();
            foreach ($rows as $index => $row) {
                if (!$column->isEmpty() && empty($row[$columnKey])) {
                    if ($column->isNumeric()) {
                        $rows[$index][$columnKey] = 0;
                        continue;
                    }
                    $request->setAttribute('report', $report);
                    $this->raiseError(
                        $request, 'Vui lòng nhập đầy đủ các số liệu'
                    );
                    $appView->doView('error');
                }
            }
        }
        ReportUtil::updateReportValues($rows, $report->getId());
        $report = ReportUtil::getReportById($report->getId());
        $request->setAttribute('report', $report);
        $this->message($request, 'Cập nhật thành công');
        $appView->doView('error');
    }
}