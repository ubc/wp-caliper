<?php
namespace IMSGlobal\Caliper\util;

use IMSGlobal\Caliper\Options;

class JsonUtil {
    /**
     * PHP's json_encode() shamefully lacks the ability to remove empty structures and null
     * values from the JSON it produces.  The best solution is this recursive method, which
     * calls jsonSerialize() on every object that implements the JsonSerializable interface,
     * as json_encode() would, then use an array filter to remove the empty structures or
     * null values.
     *
     * This method has the general name "preserialize", because in the future it may be a
     * useful place to add other functionality that json_encode() doesn't support.
     *
     * @param $object
     * @param Options $options
     * @return array|mixed
     */
    public static function preserialize($object, Options $options) {
        $processedObject = $object;

        if ($processedObject instanceof \JsonSerializable) {
            $processedObject = $processedObject->jsonSerialize();
        }

        if (is_array($processedObject)) {
            $jsonInclude = $options->getJsonInclude()->getValue();

            if ($jsonInclude === JsonInclude::NON_EMPTY) {
                $processedObject = array_filter($processedObject, self::isNonemptyNonnull());
            } elseif ($jsonInclude === JsonInclude::NON_NULL) {
                $processedObject = array_filter($processedObject, self::isNonnull());
            }

            foreach ($processedObject as $key => $value) {
                $processedObject[$key] = self::preserialize($value, $options);
            }
        }

        return $processedObject;
    }

    /**
     * Return function for use with array_filter() to keep only nonempty structures and nonnull
     * values.
     *
     * This method returns a function so it's not necessary to specify the filter function to
     * array_filter() by using its name in a string.
     *
     * @return callable
     */
    public static function isNonemptyNonnull() {
        return function ($value) {
            if (is_object($value) || is_array($value)) {
                return !empty((array) $value);
            } else {
                return !is_null($value);
            }
        };
    }

    /**
     * Return function for use with array_filter() to keep only nonnull values.
     *
     * This method returns a function so it's not necessary to specify the filter function to
     * array_filter() by using its name in a string.
     *
     * @return callable
     */
    public static function isNonnull() {
        return function ($value) {
            return !is_null($value);
        };
    }
}