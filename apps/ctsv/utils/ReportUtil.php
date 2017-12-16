<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/26/2017
 * Time: 9:51 PM
 */

namespace apps\ctsv\utils;


use apps\ctsv\object\Report;
use apps\ctsv\object\ReportValue;
use apps\ctsv\object\ReportYear;
use core\database\PrepareStatement;
use core\utils\DateUtil;
use core\utils\DBUtils;
use core\utils\HashUtil;

class ReportUtil extends AppUtil
{
    /**
     * @return ReportYear[]
     */
    public static function getYears()
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('getYears');
        $result = $prepared->execute();
        $years = Array();
        while ($year = $result->fetch_object('apps\ctsv\object\ReportYear')) {
            $years[] = $year;
        }
        return $years;
    }

    /**
     * @param array $years
     *
     * @return bool
     */
    public static function updateYears($years)
    {
        $insertSQL = self::$SQL_INSTANCES->getStatement('insertYears');
        $insertData = Array();
        foreach ($years as $index => $year) {
            if (empty($year['id']) && empty($year['value'])) {
                continue;
            }
            if (empty($year['value'])) {
                return false;
            }
            if (count($insertData) > 0) {
                $insertSQL .= ',';
            }
            if (empty($year['id'])) {
                $insertData[] = HashUtil::generateId();
            } else {
                $insertData[] = $year['id'];
            }
            $insertData[] = $year['value'];
            $insertSQL .= '(?,?)';
        }
        if (!empty($insertData)) {
            $prepared = self::$SQL_INSTANCES->getPreparedStatement(
                'deleteAllYears'
            );
            $prepared->execute();

            $prepared = new PrepareStatement($insertSQL);
            $prepared->execute($insertData);
        }
        return true;
    }

    /**
     * @param string $name
     * @param string $templateId
     * @param string $yearId
     * @param array  $schools
     * @param string $expireDate
     *
     * @return bool
     */
    public static function createReport($name, $templateId, $yearId, $schools,
        $expireDate
    ) {
        $insertSQL = self::$SQL_INSTANCES->getStatement('insertReport');
        $now = DateUtil::getCurrentDateTime();
        $insertData = Array();
        foreach ($schools as $schoolId) {
            $id = HashUtil::generateId();
            if (!empty($insertData)) {
                $insertSQL .= ',';
            }
            $insertData[] = $id;
            $insertData[] = $templateId;
            $insertData[] = $name;
            $insertData[] = $yearId;
            $insertData[] = $schoolId;
            $insertData[] = $now;
            $insertData[] = DBUtils::date($expireDate);
            $insertSQL .= '(?,?,?,?,?,?,?)';
        }
        $prepared = new PrepareStatement($insertSQL);
        $prepared->execute($insertData);
        return true;
    }

    /**
     * @param string $yearId
     * @param string $schoolId
     *
     * @return Report[]
     */
    public static function getReports($yearId, $schoolId)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('getReports');
        $result = $prepared->execute(Array($yearId, $schoolId));
        $reports = Array();
        while ($row = $result->fetch_assoc()) {
            $report = new Report(
                $row['id'], $row['name'],
                DateUtil::parseDateTime($row['dt_create'], 'd-m-Y H:i:s'),
                DateUtil::parseDate($row['dt_expire'], 'd-m-Y'),
                DateUtil::parseDateTime($row['dt_report'], 'd-m-Y H:i:s'),
                DateUtil::parseDateTime($row['dt_lst_update'], 'd-m-Y H:i:s')
            );
            $reports[] = $report;
        }
        return $reports;
    }

    /**
     * @param array $rows
     * @param string $reportId
     *
     * @return bool
     */
    public static function updateReportValues($rows, $reportId)
    {
        $insertSQL = self::$SQL_INSTANCES->getStatement('insertReportValues');
        $rowId = 0;
        $insertData = Array();
        foreach ($rows as $row) {
            $rowId++;
            foreach ($row as $column => $value) {
                if (!empty($insertData)) {
                    $insertSQL .= ',';
                }
                $insertData[] = $reportId;
                $insertData[] = $rowId;
                $insertData[] = $column;
                $insertData[] = $value;
                $insertSQL .= '(?,?,?,?)';
            }
        }
        if (!empty($insertData)) {
            $prepared = self::$SQL_INSTANCES->getPreparedStatement(
                'deleteReportValuesByReportId'
            );
            $prepared->execute(Array($reportId));

            $prepared = new PrepareStatement($insertSQL);
            $prepared->execute($insertData);

            $now = DateUtil::getCurrentDateTime();
            $prepared = self::$SQL_INSTANCES->getPreparedStatement(
                'updateReportDate'
            );
            $prepared->execute(Array($now, $reportId));

            $prepared = self::$SQL_INSTANCES->getPreparedStatement(
                'updateReportLastUpdateDate'
            );
            $prepared->execute(Array($now, $reportId));
        }
        return true;
    }

    /**
     * @param string $reportId
     *
     * @return bool
     */
    public static function deleteReport($reportId)
    {
        $report = self::getReportById($reportId);
        if (empty($report)) {
            return false;
        }

        $prepared = self::$SQL_INSTANCES->getPreparedStatement('deleteReport');
        $prepared->execute(Array($reportId));
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'deleteReportValue'
        );
        $prepared->execute(Array($reportId));

        return true;
    }

    /**
     * @param string $id
     *
     * @return Report|null
     */
    public static function getReportById($id)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('getReportById');
        $result = $prepared->execute(Array($id));
        $report = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $report = new Report(
                $row['id'], $row['name'],
                DateUtil::parseDateTime($row['dt_create'], 'd-m-Y H:i:s'),
                DateUtil::parseDate($row['dt_expire'], 'd-m-Y'),
                DateUtil::parseDateTime($row['dt_report'], 'd-m-Y H:i:s'),
                DateUtil::parseDateTime($row['dt_lst_update'], 'd-m-Y H:i:s')
            );
            $year = self::getYearById($row['id_year']);
            $report->setYear($year);
            $school = SchoolUtil::getSchoolById($row['id_school']);
            $report->setSchool($school);
            $template = TemplateUtil::getTemplateById($row['id_template']);
            $report->setTemplate($template);
            $values = self::getReportValuesByReportId($id);
            $report->setValue($values);
        }
        return $report;
    }

    /**
     * @param string $id
     *
     * @return null|ReportYear
     */
    public static function getYearById($id)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('getYearById');
        $result = $prepared->execute(Array($id));
        /** @var ReportYear $year */
        $year = null;
        if ($result->num_rows > 0) {
            $year = $result->fetch_object('apps\ctsv\object\ReportYear');
        }
        return $year;
    }

    /**
     * @param string $id
     *
     * @return ReportValue[]
     */
    public static function getReportValuesByReportId($id)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'getReportValueByReportId'
        );
        $result = $prepared->execute(Array($id));
        $reportValues = Array();
        while ($row = $result->fetch_assoc()) {
            $reportValues[$row['cd_row']][$row['column_key']] = $row['value'];
        }
        return $reportValues;
    }

    public static function updateReport($reportId, $name, $templateId, $yearId,
        $expireDate
    ) {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('updateReport');
        $prepared->execute(
            Array(
                $templateId,
                $name,
                $yearId,
                DBUtils::date($expireDate),
                $reportId)
        );
        return true;
    }
}