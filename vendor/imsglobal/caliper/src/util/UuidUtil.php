<?php

namespace IMSGlobal\Caliper\util;

class UuidUtil {
    static function makeUuidV4($data = null) {
        if (is_null($data)) {
            $data = openssl_random_pseudo_bytes(16);
        }

        assert(strlen($data) == 16);

        // I.e., result[14] = '4'
        $data[6] = chr(ord($data[6]) & 0b0100 | 0x40); // set version to 0b0100

        // I.e., result[19] in ['8', '9', 'a', 'b']
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 0b10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}