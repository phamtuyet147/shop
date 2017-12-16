<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/23/2017
 * Time: 10:12 AM
 */

namespace apps\ctsv\object;


class ReportYear
{
    private $id;
    private $year_value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getYearValue()
    {
        return $this->year_value;
    }

    /**
     * @param mixed $year_value
     */
    public function setYearValue($year_value)
    {
        $this->year_value = $year_value;
    }
}