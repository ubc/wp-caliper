<?php
namespace IMSGlobal\Caliper\util;

class Type {
    /**
     * Return true if the argument is an array and all of its keys are strings.  Otherwise, return
     * false.
     *
     * @param array $array
     * @return bool formatted timestamp
     */
    static function isStringKeyedArray($array) {
        if (!is_array($array) || [] === $array) return false;
        return count(array_filter(array_keys($array), 'is_integer')) == 0;
    }
}