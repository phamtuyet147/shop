<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/23/2017
 * Time: 10:42 AM
 */

namespace apps\ctsv\object;


class ReportValue
{
    private $id;
    private $rowId;
    private $columnKey;
    private $value;

    public function __construct($id, $rowId, $columnKey, $value)
    {
        $this->id = $id;
        $this->rowId = $rowId;
        $this->columnKey = $columnKey;
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
     * @return int
     */
    public function getRowId()
    {
        return $this->rowId;
    }

    /**
     * @param int $rowId
     */
    public function setRowId($rowId)
    {
        $this->rowId = $rowId;
    }

    /**
     * @return string
     */
    public function getColumnKey()
    {
        return $this->columnKey;
    }

    /**
     * @param string $columnKey
     */
    public function setColumnKey($columnKey)
    {
        $this->columnKey = $columnKey;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}