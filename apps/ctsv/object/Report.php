<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/23/2017
 * Time: 9:21 AM
 */

namespace apps\ctsv\object;


class Report
{
    private $id;
    private $name;
    private $year;
    private $school;
    private $createdDate;
    private $expireDate;
    private $reportDate;
    private $lastUpdateDate;
    private $template;
    private $value;

    /**
     * Report constructor.
     *
     * @param string              $id
     * @param string              $name
     * @param string              $createdDate
     * @param string              $expireDate
     * @param string              $reportDate
     * @param string              $lastUpdateDate
     * @param null|ReportYear     $year
     * @param null|School         $school
     * @param null|Template       $template
     * @param array|ReportValue[] $value
     */
    public function __construct($id, $name, $createdDate, $expireDate,
        $reportDate = '', $lastUpdateDate = '', $year = null,
        $school = null, $template = null, $value = Array()
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->createdDate = $createdDate;
        $this->expireDate = $expireDate;
        $this->reportDate = $reportDate;
        $this->lastUpdateDate = $lastUpdateDate;
        $this->year = $year;
        $this->school = $school;
        $this->template = $template;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ReportYear
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param ReportYear $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return School
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param School $school
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }

    /**
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param string $createdDate
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @return string
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @param string $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;
    }

    /**
     * @return string
     */
    public function getReportDate()
    {
        return $this->reportDate;
    }

    /**
     * @param string $reportDate
     */
    public function setReportDate($reportDate)
    {
        $this->reportDate = $reportDate;
    }

    /**
     * @return string
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }

    /**
     * @param string $lastUpdateDate
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;
    }

    /**
     * @return ReportValue[]
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param ReportValue[] $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param Template $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }
}