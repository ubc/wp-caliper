<?php
namespace IMSGlobal\Caliper\util;

/**
 * Class JsonInclude
 *
 * Inspired by JsonInclude.Include from Jackson, a JSON library for Java.
 *
 * See:
 * http://fasterxml.github.io/jackson-annotations/javadoc/2.0.5/com/fasterxml/jackson/annotation/JsonInclude.Include.html
 */
class JsonInclude extends BasicEnum {
    const
        /** @const Property is to be always included, independent of value of the property. */
        ALWAYS = 'ALWAYS',
        /** @const Not implemented: Only properties with non-default values are included. */
        NON_DEFAULT = 'NON_DEFAULT',
        /** @const Only properties with values that are non-null or are structures that are non-empty are included. */
        NON_EMPTY = 'NON_EMPTY',
        /** @const Only properties with non-null values are included. */
        NON_NULL = 'NON_NULL';
}