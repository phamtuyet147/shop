<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/23/2017
 * Time: 10:12 AM
 */

namespace apps\ctsv\object;


class ReportColumn
{
    private $templateId;
    private $columnKey;
    private $name;
    private $empty;
    private $numeric;
    private $rowSpan;
    private $colSpan;
    private $colCell;

    /**
     * ReportColumn constructor.
     *
     * @param string  $templateId
     * @param string  $columnKey
     * @param string  $name
     * @param boolean $empty
     * @param boolean $numeric
     */
    public function __construct($templateId, $columnKey, $name, $empty,
        $numeric, $rowSpan, $colSpan
    ) {
        $this->templateId = $templateId;
        $this->columnKey = $columnKey;
        $this->name = $name;
        $this->empty = $empty;
        $this->numeric = $numeric;
        $this->rowSpan = $rowSpan;
        $this->colSpan = $colSpan;
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param string $templateId
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
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
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->empty;
    }

    /**
     * @param boolean $empty
     */
    public function setEmpty($empty)
    {
        $this->empty = $empty;
    }

    /**
     * @return boolean
     */
    public function isNumeric()
    {
        return $this->numeric;
    }

    /**
     * @param boolean $numeric
     */
    public function setNumeric($numeric)
    {
        $this->numeric = $numeric;
    }

    /**
     * @return int
     */
    public function getColSpan()
    {
        return $this->colSpan;
    }

    /**
     * @param int $colSpan
     */
    public function setColSpan($colSpan)
    {
        $this->colSpan = $colSpan;
    }

    /**
     * @return int
     */
    public function getRowSpan()
    {
        return $this->rowSpan;
    }

    /**
     * @param int $rowSpan
     */
    public function setRowSpan($rowSpan)
    {
        $this->rowSpan = $rowSpan;
    }

    /**
     * @return string
     */
    public function getColCell()
    {
        return $this->colCell;
    }

    /**
     * @param string $colCell
     */
    public function setColCell($colCell)
    {
        $this->colCell = $colCell;
    }
}