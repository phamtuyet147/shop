<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/30/2017
 * Time: 4:32 PM
 */

namespace apps\ctsv\object;


use core\utils\DateUtil;

class Template
{
    private $id;
    private $name;
    private $createDate;
    private $lastUpdateDate;
    private $columns;
    private $defaultRows;

    /**
     * Template constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $createDate
     * @param string $lastUpdateDate
     * @param array|ReportColumn[] $columns
     * @param array|ReportValue[] $defaultRows
     */
    public function __construct($id, $name, $createDate, $lastUpdateDate,
        $columns = Array(), $defaultRows = Array()
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->createDate = DateUtil::parseDateTime($createDate, 'd-m-Y H:i:s');
        $this->lastUpdateDate = DateUtil::parseDateTime(
            $lastUpdateDate, 'd-m-Y H:i:s'
        );
        $this->columns = $columns;
        $this->defaultRows = $defaultRows;
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
     * @return string
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param string $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
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
     * @return ReportColumn[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param ReportColumn[] $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return ReportValue[]
     */
    public function getDefaultRows()
    {
        return $this->defaultRows;
    }

    /**
     * @param ReportValue[] $defaultRows
     */
    public function setDefaultRows($defaultRows)
    {
        $this->defaultRows = $defaultRows;
    }

}