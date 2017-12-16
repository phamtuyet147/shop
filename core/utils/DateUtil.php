<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/30/2017
 * Time: 4:36 PM
 */

namespace core\utils;


use DateInterval;
use DateTime;
use DateTimeZone;

final class DateUtil
{
    private static $TIME_ZONE = 'Asia/Ho_Chi_Minh';

    /**
     * Get current system date
     *
     * @param null $format
     *
     * @return false|string
     */
    public static function getCurrentDate($format = null)
    {
        $timezone = new DateTimeZone(self::$TIME_ZONE);
        $date     = new DateTime('now', $timezone);
        if (!empty($format)) {
            return $date->format($format);
        }
        return $date->format('Y-m-d');
    }

    /**
     * Get current system datetime
     *
     * @param null $format
     *
     * @return false|string
     */
    public static function getCurrentDateTime($format = null)
    {
        $timezone = new DateTimeZone(self::$TIME_ZONE);
        $datetime = new DateTime('now', $timezone);
        if (!empty($format)) {
            return $datetime->format($format);
        }
        return $datetime->format('Y-m-d H:i:s');
    }

    /**
     * Parse string to date
     *
     * @param string $date
     * @param null   $format
     *
     * @return false|string
     */
    public static function parseDate($date, $format = null)
    {
        if (empty($date)) {
            return '';
        }
        $date = new DateTime($date);
        if (!empty($format)) {
            return $date->format($format);
        }
        return $date->format('Y-m-d');
    }

    /**
     * Parse string to datetime
     *
     * @param string $datetime
     * @param null   $format
     *
     * @return false|string
     */
    public static function parseDateTime($datetime, $format = null)
    {
        if (empty($datetime)) {
            return '';
        }
        $datetime = new DateTime($datetime);
        if (!empty($format)) {
            return $datetime->format($format);
        }
        return $datetime->format('Y-m-d H:i:s');
    }

    /**
     * @param string $datetime
     * @param string $datetimeInterval
     * @param bool   $flagString
     * @param null   $format
     *
     * @return false|string
     */
    public static function getPreviousDateTime($datetime, $datetimeInterval,
        $flagString = true, $format = null
    ) {
        $date = new DateTime($datetime);
        if ($flagString) {
            $interval = DateInterval::createFromDateString($datetimeInterval);
        } else {
            $interval = new DateInterval($datetimeInterval);
        }
        $date = $date->sub($interval);
        if (!empty($format)) {
            return $date->format($format);
        }
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @param      $datetime
     * @param      $datetimeInterval
     * @param bool $flagString
     * @param null $format
     *
     * @return string
     */
    public static function getNextDateTime($datetime, $datetimeInterval,
        $flagString = true, $format = null
    ) {
        $date = new DateTime($datetime);
        if ($flagString) {
            $interval = DateInterval::createFromDateString($datetimeInterval);
        } else {
            $interval = new DateInterval($datetimeInterval);
        }
        $date = $date->add($interval);
        if (!empty($format)) {
            return $date->format($format);
        }
        return $date->format('Y-m-d H:i:s');
    }
}