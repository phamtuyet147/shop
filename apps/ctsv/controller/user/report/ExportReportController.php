<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 9/2/2017
 * Time: 7:02 PM
 */

namespace apps\ctsv\controller\user\report;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\ReportUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use core\utils\StringUtils;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;

class ExportReportController extends BaseAppController
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     *
     */
    public function execute(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $pagePath = $request->getPagePath();
        $reportId = '';
        if (preg_match('/xuat-bao-cao\/([a-z0-9]+)/', $pagePath, $match)) {
            $reportId = $match[1];
        }
        if (empty($reportId)) {
            $response->redirect('/index.php?path=bao-cao');
        }
        $report = ReportUtil::getReportById($reportId);
        if (empty($report)) {
            $response->redirect('/index.php?path=bao-cao');
        }

        require W_ROOT . "/core/libraries/PHPExcel/Classes/PHPExcel.php";
        require W_ROOT
            . "/core/libraries/PHPExcel/Classes/PHPExcel/IOFactory.php";

        // Create new PHPExcel object
        $workbook = new PHPExcel();

        // Set document properties
        $workbook->getProperties()->setCreator("DHQG TPHCM")
            ->setLastModifiedBy("DHQG TPHCM")
            ->setTitle($report->getName())
            ->setSubject($report->getName())
            ->setDescription($report->getName())
            ->setKeywords($report->getName())
            ->setCategory($report->getName());

        $columns = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
                         'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V',
                         'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF',
                         'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO',
                         'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX',
                         'AY', 'AZ');
        $styles = array(
            'font'      => array(
                'size' => 12,
                'name' => 'Times New Roman'
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'     => true
            )
        );

        $activeSheet = $workbook->setActiveSheetIndex(0);
        $activeSheet->getParent()->getDefaultStyle()->applyFromArray($styles);
        $noColumn = -1;
        $styles = array(
            'font'      => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $noColumn = 0;
        $reportColumns = $report->getTemplate()->getColumns();
        $noRow = 7;
        do {
            $index = 0;
            $noRow++;
            $subColumns = array();
            $colIndex = 0;
            while ($index < count($reportColumns)) {
                $column = $reportColumns[$index];
                $colCell = $column->getColCell();
                if (empty($colCell)) {
                    $colCell = $colIndex;
                }
                $activeSheet->setCellValue(
                    $columns[$colCell] . $noRow, $column->getName()
                );
                $activeSheet->getStyle($columns[$colCell] . $noRow)
                    ->applyFromArray($styles);
                if ($column->getRowSpan() > 1) {
                    $activeSheet->mergeCells(
                        $columns[$colCell] . $noRow . ':' . $columns[$colCell]
                        . ($noRow + $column->getRowSpan() - 1)
                    );
                }
                if ($column->getColSpan() > 1) {
                    $activeSheet->mergeCells(
                        $columns[$colCell] . $noRow . ':' . $columns[$colCell
                        + $column->getColSpan() - 1] . $noRow
                    );
                    $noSubColumn = 0;
                    $colSpan = $column->getColSpan();
                    while ($noSubColumn < $colSpan) {
                        $index++;
                        $column = $reportColumns[$index];
                        $column->setColCell($colIndex);
                        $subColumns[] = $column;
                        if ($column->getColSpan() == 1) {
                            $noSubColumn++;
                            $colIndex++;
                        }
                    }
                } else {
                    $colIndex++;
                }
                $index++;
            }
            $reportColumns = $subColumns;
            if ($noRow == 8) {
                $noColumn = $colIndex - 1;
            }
        } while (!empty($reportColumns));

        $activeSheet->mergeCells(
            'A2:' . $columns[$noColumn] . '2'
        );
        $activeSheet->setCellValue(
            'A2', 'ĐẠI HỌC QUỐC GIA THÀNH PHỐ HỒ CHÍ MINH'
        );
        $activeSheet->mergeCells(
            'A3:' . $columns[$noColumn] . '3'
        );
        $activeSheet->setCellValue('A3', $report->getSchool()->getName());
        $activeSheet->mergeCells(
            'A5:' . $columns[$noColumn] . '5'
        );
        $activeSheet->setCellValue(
            'A5', $report->getName()
        );
        $activeSheet->mergeCells(
            'A6:' . $columns[$noColumn] . '6'
        );
        $activeSheet->setCellValue(
            'A6', 'Năm học: ' . $report->getYear()->getYearValue()
        );
        $activeSheet->getStyle('A2')->applyFromArray($styles);
        $activeSheet->getStyle('A3')->applyFromArray($styles);
        $activeSheet->getStyle('A5')->applyFromArray($styles);
        $activeSheet->getStyle('A6')->applyFromArray($styles);

        $lastRow = $noRow;
        $reportValues = $report->getValue();
        $reportColumns = $report->getTemplate()->getColumns();
        foreach ($reportValues as $rowId => $row) {
            $excelRow = $noRow + $rowId;
            $lastRow = $excelRow;
            $excelCol = 0;
            foreach ($reportColumns as $column) {
                if ($column->getColSpan() > 1) {
                    continue;
                }
                $value = $row[$column->getColumnKey()];
                $activeSheet->setCellValue(
                    $columns[$excelCol] . $excelRow, $value
                );
                $excelCol++;
            }
        }
        $styles = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $activeSheet->getStyle('A8:' . $columns[$noColumn] . $lastRow)
            ->applyFromArray($styles);

        $createCol = 1;
        if (($noColumn + 1) / 2 - 3 > 1) {
            $createCol = round(($noColumn + 1) / 2 - 3);
        }
        $activeSheet->mergeCells(
            'A' . ($lastRow + 2) . ':' . $columns[$createCol - 1] . ($lastRow
                + 2)
        );
        $activeSheet->setCellValue(
            'A' . ($lastRow + 2), 'Người lập bảng'
        );

        $activeSheet->mergeCells(
            $columns[$createCol + 3] . ($lastRow + 2) . ':'
            . $columns[$noColumn] . ($lastRow + 2)
        );
        $activeSheet->setCellValue(
            $columns[$createCol + 3] . ($lastRow + 2),
            'Thành phố Hồ Chí Minh, ngày  _  tháng  _  năm'
        );
        $activeSheet->mergeCells(
            $columns[$createCol + 3] . ($lastRow + 3) . ':'
            . $columns[$noColumn] . ($lastRow + 3)
        );
        $activeSheet->setCellValue(
            $columns[$createCol + 3] . ($lastRow + 3),
            'THỦ TRƯỞNG ĐƠN VỊ'
        );
        $styles = array(
            'font'      => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $activeSheet->getStyle('A' . ($lastRow + 2))->applyFromArray($styles);
        $activeSheet->getStyle($columns[$createCol + 3] . ($lastRow + 2))
            ->applyFromArray($styles);
        $activeSheet->getStyle($columns[$createCol + 3] . ($lastRow + 3))
            ->applyFromArray($styles);

        $filename = StringUtils::convertStringToURL($report->getName())
            . ".xls";

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header(
            'Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'
        ); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($workbook, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}