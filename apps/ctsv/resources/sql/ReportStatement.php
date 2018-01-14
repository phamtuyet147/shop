<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 9/19/2017
 * Time: 9:48 PM
 */

namespace apps\ctsv\resources\sql;


use core\utils\SQLStatements;

class ReportStatement extends SQLStatements
{
    protected static $STATEMENTS
        = Array(
            'getUserLogin'                       =>
                'SELECT * FROM users WHERE username = ? AND password = ?',
            'getUsers'                           =>
                'SELECT * FROM users',
            'getUserById'                        =>
                'SELECT * FROM users WHERE id = ?',
            'insertUser'                         =>
                'INSERT INTO users(id, username, password) VALUES(?,?,?)',
            'insertUserSchools'                  =>
                'INSERT INTO user_schools(id_user, id_school) VALUES @Values',
            'deleteUserSchoolsByUserId'          =>
                'DELETE FROM user_schools WHERE id_user = ?',
            'getSchoolInfoByUserId'              =>
                'SELECT * FROM schools WHERE id IN (SELECT id_school FROM user_schools WHERE id_user = ?)',
            'getSchoolById'                      =>
                'SELECT * FROM schools WHERE id = ?',
            'getAllSchools'                      =>
                'SELECT * FROM schools',
            'getYears'                           =>
                'SELECT * FROM years ORDER BY id DESC',
            'getYearById'                        =>
                'SELECT * FROM years WHERE id = ?',
            'insertYears'                        =>
                'INSERT INTO years VALUES @Values',
            'deleteAllYears'                     =>
                'DELETE FROM years',
            'deleteAllSchools'                   =>
                'DELETE FROM schools',
            'insertSchools'                      =>
                'INSERT INTO schools (id, name) VALUES @Values',
            'insertReport'                       =>
                'INSERT INTO reports (id, id_template, name, id_year, id_school, dt_create, dt_expire) VALUES @Values',
            'updateReport'                       =>
                'UPDATE reports SET id_template = ?, name = ?, id_year = ?, dt_expire = ? WHERE id = ?',
            'getTemplates'                       =>
                'SELECT * FROM report_templates',
            'getTemplateById'                    =>
                'SELECT * FROM report_templates WHERE id = ?',
            'getTemplateColumnsByTemplateId'     =>
                'SELECT * FROM report_columns WHERE id_template = ? ORDER BY cd_order',
            'getTemplateDefaultRowsByTemplateId' =>
                'SELECT * FROM report_default_rows WHERE id_template = ?',
            'insertTemplate'                     =>
                'INSERT INTO report_templates (id, name, dt_create, dt_lst_update) VALUES (?, ?, ?, ?)',
            'updateTemplateById'                 =>
                'UPDATE report_templates SET name = ?, dt_lst_update = ? WHERE id = ?',
            'deleteTemplateColumnsByTemplateId'  =>
                'DELETE FROM report_columns WHERE id_template = ?',
            'insertColumns'                      =>
                'INSERT INTO report_columns(id_template, column_key, name, flag_empty, flag_numeric, row_span, col_span, cd_order) VALUES @Values',
            'getReports'                         =>
                'SELECT * FROM reports WHERE id_year = ? AND id_school = ? ORDER BY dt_lst_update, dt_expire',
            'getReportById'                      =>
                'SELECT * FROM reports WHERE id = ? LIMIT 1',
            'getReportValueByReportId'           =>
                'SELECT * FROM report_values WHERE id_report = ?',
            'insertReportValues'                 =>
                'INSERT INTO report_values (id_report, cd_row, column_key, `value`) VALUES @Values',
            'updateReportDate'                   =>
                'UPDATE reports SET dt_report = ? WHERE id = ? AND dt_report IS NULL LIMIT 1',
            'updateReportLastUpdateDate'         =>
                'UPDATE reports SET dt_lst_update = ? WHERE id = ? LIMIT 1',
            'deleteReportValuesByReportId'       =>
                'DELETE FROM report_values WHERE id_report = ?',
            'deleteReport'                       =>
                'DELETE FROM reports WHERE id = ? LIMIT 1',
            'deleteReportValue'                  =>
                'DELETE FROM report_values WHERE id_report = ?',
            'getReportsInuseBeTemplateId'        =>
                'SELECT id FROM reports WHERE id_template = ? AND dt_report IS NOT NULL LIMIT 1',
            'deleteTemplate'                     =>
                'DELETE FROM report_templates WHERE id = ?',
            'deleteColumns'                      =>
                'DELETE FROM report_columns WHERE id_template = ?',
            'updateUserPassword'                 =>
                'UPDATE users SET password = ? WHERE id = ?'
        );
}