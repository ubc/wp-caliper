<?php
namespace IMSGlobal\Caliper\util;

use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\events\Event;
use IMSGlobal\Caliper\context;

/**
 * Class ClassUtil
 *
 * Provide useful methods to overcome OOP shortcomings in some versions of PHP.
 */
class ClassUtil {
    /**
     * The "::class" notation isn't available until PHP 5.5.  This method is a workaround for
     * older versions of PHP.
     *
     * @deprecated Remove PHP 5.4 requirements from caliper-php, then replace calls to this method
     *     with reference to "::class" instead.
     * @return string Name of this class
     */
    static public function className() {
        return get_called_class();
    }

    /**
     * Examine the serialization data of Caliper Entity objects that are the children
     * (either directly or in an array) of a given Caliper object.  Remove the
     * context from each child if it and the specified parent context are the same.
     *
     * > "When data storage reaches the ceiling, you need contextual healing."
     *
     * Also limited support for context coercion of this kind:
     *
     *     [[
     *         'member' => [
     *             'id' => 'Person',
     *             'type' => 'id',
     *         ],
     *     ]]
     *
     * Which replaces `Person` objects in the `member` property with the value of the
     * objects' `id` property.
     *
     * @param array $serializationData Object property array (from $this->jsonSerialize())
     * @param Entity|Event $parent
     * @return array $serializationData with possible updates
     */
    protected function removeChildEntitySameContextsBase(array $serializationData, $parent) {
        $contextProperty = $parent->getContext()->getPropertyName();
        $parentContext = $parent->getContext()->getValue();
        $defaultContext = new context\Context(context\Context::CONTEXT);
        $removableContexts = [$defaultContext];
        if (is_string($parentContext)) {
            $removableContexts []= $parentContext;
        } elseif (is_array($parentContext)) {
            array_merge($removableContexts, $parentContext);
        }

        foreach ($serializationData as &$value) {
            if ($value instanceof \JsonSerializable) {
                $value = $value->jsonSerialize();
                if (is_array($value) && array_key_exists($contextProperty, $value)) {
                    if (is_array($value[$contextProperty]) && count($value[$contextProperty]) > 1) {
                        // inner object has array of contexts - not trying to thin
                        continue;
                    } elseif (is_array($value[$contextProperty]) && count($value[$contextProperty]) == 1) {
                        $comparableContext = array_pop($value[$contextProperty]);
                    } else {
                        $comparableContext = $value[$contextProperty];
                    }

                    if (in_array($comparableContext, $removableContexts)) {
                        $value[$contextProperty] = null;
                    }
                }
            } elseif (is_array($value)) {
                $value = self::removeChildEntitySameContextsBase($value, $parent);
            }
        }

        // Limited coercion support
        if (isset($serializationData['@context']) && is_array($serializationData['@context'])) {
            foreach ($serializationData['@context'] as $contextItem) {
                if (is_array($contextItem)) {
                    foreach ($contextItem as $contextKey => $contextCoercion) {
                        $objectTypeId = @$serializationData[$contextKey]['type'];
                        $coercionTypeId = @$contextCoercion['id'];
                        if ($objectTypeId == $coercionTypeId) {
                            $serializationData[$contextKey] = $serializationData[$contextKey][$contextCoercion['type']];
                        }
                    }
                }
            }
        }

        return $serializationData;
    }
}
