<?php

namespace IMSGlobal\Caliper\util;

class TimestampUtil {
    /**
     * Given a \DateTime object, return a string representation in ISO 8601 format, including
     * milliseconds, in UTC.
     *
     * @param \DateTime $timestamp
     * @return string formatted timestamp
     */
    static function formatTimeISO8601MillisUTC($timestamp) {
        if ($timestamp == null) {
            return null;
        }

        $timestampClone = (clone $timestamp);
        $timestampClone->setTimezone(new \DateTimeZone('UTC'));

        return substr($timestampClone->format('Y-m-d\TH:i:s.u'), 0, -3) . 'Z'; // truncate μs to ms
    }

    /**
     * Instantiate a DateTime object which includes fractional seconds, based on the current time
     * or a specific floating point epoch timestamp.
     *
     * By default, PHP doesn't include fractional seconds in DateTime objects that were
     * instantiated without a timestamp argument.  A few other functions must be used together as
     * a workaround.
     *
     * @param float|null $timestampWithFraction
     * @param int $precision
     * @return \DateTime timestamp
     */
    static function makeDateTimeWithSecondsFraction($timestampWithFraction = null, $precision = 3) {
        if (!is_null($timestampWithFraction)) {
            $timestampWithFraction = floatval($timestampWithFraction);
        } else {
            $timestampWithFraction = microtime($returnFloat = true);
        }

        return \DateTime::createFromFormat('U.u',
            number_format($timestampWithFraction, $precision, '.', ''));
    }
}