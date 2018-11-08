<?php

/**
 * Class CaliperTestUtilities
 *
 * @requires PHP 5.6.28
 */
class CaliperTestUtilities {
    public static function saveFormattedFixtureAndTestJson($fixtureJson, $testJson,
                                                           $filename, $outputDirectoryPath) {
        if ($outputDirectoryPath !== false) {
            self::writeJsonFile($outputDirectoryPath . DIRECTORY_SEPARATOR . $filename . '_output.json',
                self::formatJson($testJson));
            self::writeJsonFile($outputDirectoryPath . DIRECTORY_SEPARATOR . $filename . '_fixture.json',
                self::formatJson($fixtureJson));
        }
    }

    private static function writeJsonFile($jsonFilePath, $formattedJson) {
        if (file_put_contents($jsonFilePath, $formattedJson) === false) {
            throw new PHPUnit_Runner_Exception("Error writing '${$jsonFilePath}'");
        }
    }

    private static function formatJson($json) {
        $objects = json_decode($json);
        self::ksortObjectsRecursive($objects);

        return json_encode($objects, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION);
    }

    public static function ksortObjectsRecursive(&$data, $sortFlags = SORT_REGULAR) {
        if (!function_exists('ksortObjectsRecursiveCallback')) {
            function ksortObjectsRecursiveCallback(&$data, $unusedKey, $sortFlags) {
                $dataWasCastAsArray = false;
                if (is_object($data)) {
                    $data = (array) $data;
                    $dataWasCastAsArray = true;
                }

                $success = is_array($data) &&
                    ksort($data, $sortFlags) &&
                    array_walk($data, __FUNCTION__, $sortFlags);

                if ($dataWasCastAsArray) {
                    $object = new stdClass();
                    foreach ($data as $key => $value) {
                        $object->$key = $value;
                    }
                    $data = $object;
                }

                return $success;
            }
        }

        return ksortObjectsRecursiveCallback($data, null, $sortFlags);
    }
}