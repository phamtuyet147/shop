<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/30/2017
 * Time: 4:30 PM
 */

namespace apps\ctsv\utils;


use apps\ctsv\object\ReportColumn;
use apps\ctsv\object\ReportValue;
use apps\ctsv\object\Template;
use core\database\PrepareStatement;
use core\utils\DateUtil;
use core\utils\DBUtils;
use core\utils\HashUtil;
use core\utils\StringUtils;

class TemplateUtil extends AppUtil
{
    /**
     * @return Template[] array
     */
    public static function getTemplates()
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'getTemplates'
        );
        $result = $prepared->execute();
        $templates = Array();
        while ($row = $result->fetch_assoc()) {
            $template = new Template(
                $row['id'], $row['name'], $row['dt_create'],
                $row['dt_lst_update']
            );
            $templates[] = $template;
        }
        return $templates;
    }

    /**
     * @param string $templateId
     *
     * @return null|Template
     */
    public static function getTemplateById($templateId)
    {
        /** @var Template $template */
        $template = null;
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'getTemplateById'
        );
        $result = $prepared->execute(Array($templateId));
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $template = new Template(
                $row['id'], $row['name'], $row['dt_create'],
                $row['dt_lst_update']
            );
            $columns = self::getTemplateColumnsByTemplateId($templateId);
            $template->setColumns($columns);
            $defaultRows = self::getTemplateDefaultRowsByTemplateId(
                $templateId
            );
            $template->setDefaultRows($defaultRows);
        }
        return $template;
    }

    /**
     * @param string $templateId
     *
     * @return ReportColumn[]
     */
    public static function getTemplateColumnsByTemplateId($templateId)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'getTemplateColumnsByTemplateId'
        );
        $result = $prepared->execute(Array($templateId));
        $columns = Array();
        while ($row = $result->fetch_assoc()) {
            $column = new ReportColumn(
                $row['id_template'], $row['column_key'], $row['name'],
                StringUtils::toBoolean($row['flag_empty']),
                StringUtils::toBoolean($row['flag_numeric']),
                $row['row_span'], $row['col_span']
            );
            $columns[] = $column;
        }
        return $columns;
    }

    /**
     * @param string $templateId
     *
     * @return ReportValue[]
     */
    public static function getTemplateDefaultRowsByTemplateId($templateId)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'getTemplateDefaultRowsByTemplateId'
        );
        $result = $prepared->execute(Array($templateId));
        $rows = Array();
        while ($row = $result->fetch_object('apps\ctsv\object\ReportValue')) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * @param string $templateId
     * @param string $name
     * @param array  $columns
     */
    public static function UpdateTemplate($templateId, $name, $columns)
    {
        $now = DateUtil::getCurrentDateTime();
        if (empty($templateId)) {
            $prepared = self::$SQL_INSTANCES->getPreparedStatement(
                'insertTemplate'
            );
            $templateId = HashUtil::generateId();
            $prepared->execute(Array($templateId, $name, $now, $now));
        } else {
            $prepared = self::$SQL_INSTANCES->getPreparedStatement(
                'updateTemplateById'
            );
            $prepared->execute(Array($name, $now, $templateId));
        }
        self::insertColumns($templateId, $columns);
    }

    /**
     * @param string $templateId
     * @param array  $columns
     */
    public static function insertColumns($templateId, $columns)
    {
        $insertSQL = self::$SQL_INSTANCES->getStatement('insertColumns');
        $insertData = Array();
        $index = 0;
        foreach ($columns as $column) {
            $index++;
            if (count($insertData) > 0) {
                $insertSQL .= ',';
            }
            $insertData[] = $templateId;
            $insertData[] = HashUtil::generateId();
            $insertData[] = $column['name'];
            $insertData[] = (!empty($column['flag_empty'])) ? DBUtils::boolean(
                $column['flag_empty']
            ) : 0;
            $insertData[] = (!empty($column['flag_numeric']))
                ? DBUtils::boolean($column['flag_numeric']) : 0;
            $insertData[] = $column['row_span'];
            $insertData[] = $column['col_span'];
            $insertData[] = $index;
            $insertSQL .= '(?,?,?,?,?,?,?,?)';
        }
        if (!empty($insertData)) {
            $prepared = self::$SQL_INSTANCES->getPreparedStatement(
                'deleteTemplateColumnsByTemplateId'
            );
            $prepared->execute(Array($templateId));

            $prepared = new PrepareStatement($insertSQL);
            $prepared->execute($insertData);
        }
    }

    /**
     * @param string $templateId
     *
     * @return bool
     */
    public static function deleteTemplate($templateId)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'deleteTemplate'
        );
        $prepared->execute(Array($templateId));
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('deleteColumns');
        $prepared->execute(Array($templateId));

        return true;
    }

    /**
     * @param string $templateId
     *
     * @return array|null
     */
    public static function getReportInUseByTemplateId($templateId)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'getReportsInuseBeTemplateId'
        );
        $result = $prepared->execute(Array($templateId));
        $report = null;
        if ($result->num_rows > 0) {
            $report = $result->fetch_assoc();
        }
        return $report;
    }

}