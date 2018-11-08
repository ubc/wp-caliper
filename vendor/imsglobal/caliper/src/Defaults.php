<?php
namespace IMSGlobal\Caliper;

class Defaults extends util\BasicEnum {
    const
        HOST = 'http://example.org/',
        CONNECTION_REQUEST_TIMEOUT = 10000,
        CONNECTION_TIMEOUT = 10000,
        SOCKET_TIMEOUT = 10000,
        JSON_INCLUDE = util\JsonInclude::NON_EMPTY,
        // TODO: Make PHP 5.6 required, to support math with constants.
        // TODO: Make PHP 5.6.6 required, to support `JSON_PRESERVE_ZERO_FRACTION` constant.
        JSON_ENCODE_OPTIONS = 1216, // = JSON_UNESCAPED_SLASHES (64) | JSON_PRETTY_PRINT (128) | JSON_PRESERVE_ZERO_FRACTION (1024), // (required new const syntax of PHP 5.6)
        DEBUG = false;
}
