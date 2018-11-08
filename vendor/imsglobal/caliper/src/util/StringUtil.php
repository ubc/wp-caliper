<?php
namespace IMSGlobal\Caliper\util;

class StringUtil {
    static function endsWith($haystack, $needle) {
        return (string) $needle === substr($haystack, -strlen($needle));
    }
}
